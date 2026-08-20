<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Services\WorldpayService;

class PaymentController extends Controller
{
    protected WorldpayService $worldpay;

    public function __construct(WorldpayService $worldpay)
    {
        $this->worldpay = $worldpay;
    }

    public function index()
    {
        return view('payment.form');
    }

    /**
     * Initiate Payment via Worldpay (HPP or Saved Card CIT)
     */
    public function pay(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required',
            'amount'        => 'required',
        ]);

        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        $user = Auth::user();

        try {
            $token = $this->worldpay->login($restaurant);

            // Determine if user wants to use a saved card
            $useSavedCard = $request->boolean('use_saved_card', true);
            $payerReference = ($user && $user->worldpay_unique_reference) ? $user->worldpay_unique_reference : null;

            /*
            |--------------------------------------------------------------------------
            | FLOW A: CHARGE SAVED CARD (If available & requested)
            |--------------------------------------------------------------------------
            */
            if ($payerReference && $useSavedCard) {
                $reference = 'HYST-' . strtoupper(Str::random(12));

                try {
                    $result = $this->worldpay->chargeSavedCard(
                        $restaurant,
                        $token,
                        $payerReference,
                        [
                            'reference'   => $reference,
                            'amount'      => $request->amount,
                            'description' => 'Online Order',
                            'name'        => $user->name,
                        ]
                    );

                    Log::info('Worldpay Saved Card Response', $result);

                    // 1. 3D SECURE CHALLENGE REQUIRED
                    if (!empty($result['redirectUrl'])) {
                        Payment::create([
                            'restaurant_id'  => $restaurant->id,
                            'transaction_id' => $result['redirectId'] ?? $reference,
                            'amount'         => $request->amount,
                            'payment_status' => 'pending',
                            'payment_method' => 'online',
                            'user_id'        => $user->id,
                            'checkout_data'  => json_encode($request->all()),
                        ]);

                        return redirect()->away($result['redirectUrl']);
                    }

                    // 2. DIRECT SUCCESS
                    if (($result['statusCode'] ?? null) === 'S') {
                        $payment = Payment::create([
                            'restaurant_id'          => $restaurant->id,
                            'transaction_id'         => $result['transactionId'] ?? $reference,
                            'amount'                 => $request->amount,
                            'payment_status'         => 'paid',
                            'payment_method'         => 'online',
                            'payment_transaction_id' => $result['transactionId'] ?? null,
                            'user_id'                => $user->id,
                            'checkout_data'          => json_encode($request->all()),
                        ]);

                        $data = json_decode($payment->checkout_data, true);
                        $newRequest = new Request($data);

                        app(OrderController::class)->placeOrder($newRequest, $payment);

                        return view('front.checkout-success', compact('payment', 'result'));
                    }

                    // 3. IF CHARGE FAILED, FALLBACK TO HPP BELOW
                    Log::warning('Saved card charge failed, falling back to HPP redirect', ['result' => $result]);

                } catch (\Exception $e) {
                    Log::warning('Saved card charge exception, falling back to HPP redirect: ' . $e->getMessage());
                }
            }

            /*
            |--------------------------------------------------------------------------
            | FLOW B: HOSTED PAYMENT PAGE (HPP) - First time or New Card
            |--------------------------------------------------------------------------
            */
            $reference = 'HYST-' . strtoupper(Str::random(12));
            $userId = $user ? $user->id : rand(1000, 9999);
            $userName = $user ? $user->name : ($request->name ?? 'Guest Customer');
            $userEmail = $user ? $user->email : ($request->email ?? 'guest@example.com');
            $userPhone = $request->phone ?? ($user ? $user->phone : '');

            $addressLine = ($request->order_type == 'dine_in' || $request->order_type == 'table_book')
                ? $restaurant->address
                : ($request->address ?? ($user ? $user->address : ''));

            $postcode = ($request->order_type == 'dine_in' || $request->order_type == 'table_book')
                ? $restaurant->postcode
                : ($request->postcode ?? ($user ? $user->postcode : ''));

            $state = ($request->order_type == 'dine_in' || $request->order_type == 'table_book')
                ? $restaurant->state
                : ($user ? $user->state : '');

            $country = ($request->order_type == 'dine_in' || $request->order_type == 'table_book')
                ? $restaurant->country
                : ($user ? $user->country : 'GB');

            $hpp = $this->worldpay->generateHostedPayment(
                $restaurant,
                $token,
                [
                    'reference'   => $reference,
                    'description' => 'Online Order',
                    'amount'      => $request->amount,
                    'user_id'     => $userId,
                    'name'        => $userName,
                    'email'       => $userEmail,
                    'phone'       => $userPhone,
                    'address'     => $addressLine,
                    'postcode'    => $postcode,
                    'state'       => $state,
                    'country'     => $country,
                ]
            );

            Payment::create([
                'restaurant_id'  => $restaurant->id,
                'transaction_id' => $hpp['token'],
                'amount'         => $request->amount,
                'payment_status' => 'pending',
                'payment_method' => 'online',
                'user_id'        => $user ? $user->id : null,
                'checkout_data'  => json_encode($request->all()),
            ]);

            return redirect()->away($hpp['redirectToUrl']);

        } catch (\Exception $e) {
            Log::error('Worldpay payment error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Payment Initialization Error: ' . $e->getMessage());
        }
    }

    /**
     * HPP Return Callback
     */
    public function callback(Request $request)
    {
        $webPageToken = $request->webPageToken;

        if (!$webPageToken) {
            Log::error('Worldpay Callback missing webPageToken', $request->all());
            return redirect()->route('checkout.failed')->with('error', 'Invalid payment token.');
        }

        $payment = Payment::where('transaction_id', $webPageToken)->firstOrFail();
        $restaurant = Restaurant::findOrFail($payment->restaurant_id);

        try {
            $accessToken = $this->worldpay->login($restaurant);
            $result = $this->worldpay->getHostedPaymentStatus($restaurant, $accessToken, $webPageToken);

            if (($result['status'] ?? null) === 'PROCESSED_SUCCESSFUL') {

                $paymentType = !empty($result['transaction']['card'])
                    ? 'card'
                    : (!empty($result['transaction']['bankAccount']) ? 'bank' : 'card');

                $payment->update([
                    'payment_status'           => 'paid',
                    'payment_transaction_id'   => $result['transaction']['transactionId'] ?? null,
                    'secondary_transaction_id' => $result['transaction']['secondaryTransactionId'] ?? null,
                    'payment_method'           => $result['transaction']['paymentMethod'] ?? 'online',
                    'payment_type'             => $paymentType,
                ]);

                // Save Worldpay Payer Unique Reference for returning user if logged in
                if (Auth::check() && $payment->user_id) {
                    $user = Auth::user();
                    if (!$user->worldpay_unique_reference) {
                        $user->update([
                            'worldpay_unique_reference' => 'USER-' . $user->id
                        ]);
                    }
                }

                $data = json_decode($payment->checkout_data, true);
                $newRequest = new Request($data);

                app(OrderController::class)->placeOrder($newRequest, $payment);

                return view('front.checkout-success', compact('payment', 'result'));
            }

            $payment->update(['payment_status' => 'failed']);
            return redirect()->route('checkout.failed');

        } catch (\Exception $e) {
            Log::error('Worldpay Callback Exception', ['message' => $e->getMessage()]);
            $payment->update(['payment_status' => 'failed']);
            return redirect()->route('checkout.failed')->with('error', $e->getMessage());
        }
    }

    /**
     * 3D Secure Callback Handler
     */
    public function threeDSCallback(Request $request, string $redirectId)
    {
        $payment = Payment::where('transaction_id', $redirectId)->firstOrFail();
        $restaurant = Restaurant::findOrFail($payment->restaurant_id);

        try {
            $accessToken = $this->worldpay->login($restaurant);
            $result = $this->worldpay->finalize3DSavedCardPayment($restaurant, $accessToken, $redirectId);

            Log::info('Worldpay 3DS Finalize Result', $result);

            if (($result['statusCode'] ?? null) === 'S' || ($result['status'] ?? null) === 'PROCESSED_SUCCESSFUL') {

                $payment->update([
                    'payment_status'         => 'paid',
                    'payment_transaction_id' => $result['transactionId'] ?? $redirectId,
                ]);

                $data = json_decode($payment->checkout_data, true);
                $newRequest = new Request($data);

                app(OrderController::class)->placeOrder($newRequest, $payment);

                return view('front.checkout-success', compact('payment', 'result'));
            }

            $payment->update(['payment_status' => 'failed']);
            return redirect()->route('checkout.failed')->with('error', '3D Secure Verification Failed.');

        } catch (\Exception $e) {
            Log::error('Worldpay 3DS Callback Error', ['message' => $e->getMessage()]);
            $payment->update(['payment_status' => 'failed']);
            return redirect()->route('checkout.failed')->with('error', $e->getMessage());
        }
    }

    public function callsuccess(Request $request)
    {
        $payment = Payment::findOrFail($request->payment);
        return view('front.checkout-success', compact('payment'));
    }

    public function callfailed()
    {
        return view('front.checkout-failed');
    }

    public function successpage(Request $request)
    {
        return view('front.checkout-success', ['response' => $request->all()]);
    }

    /**
     * Refund Payment via Restaurant Admin
     */
    public function refundPayment(Request $request, Order $order)
    {
        $request->validate([
            'refund_amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $payment = $order->payment;

        if (!$payment) {
            return back()->with('error', 'Payment record not found.');
        }

        if (empty($payment->payment_transaction_id)) {
            return back()->with('error', 'Transaction ID not found for this payment.');
        }

        try {
            $restaurant = $order->restaurant;
            $token = $this->worldpay->login($restaurant);

            $response = $this->worldpay->refundPayment(
                $restaurant,
                $token,
                $payment->payment_transaction_id,
                (float) $request->refund_amount,
                $payment->payment_type ?? 'card',
                "Refund for Order #{$order->id}"
            );

            DB::transaction(function () use ($payment, $request) {
                $payment->refunded_amount += $request->refund_amount;

                if ($payment->refunded_amount >= $payment->amount) {
                    $payment->payment_status = 'refunded';
                } else {
                    $payment->payment_status = 'partially_refunded';
                }

                $payment->save();
            });

            return back()->with('success', 'Refund of £' . number_format($request->refund_amount, 2) . ' processed successfully via Worldpay.');

        } catch (\Exception $e) {
            Log::error('Worldpay Refund Error', ['message' => $e->getMessage()]);
            return back()->with('error', 'Refund Failed: ' . $e->getMessage());
        }
    }

    /**
     * Webhook / Status Change Notification
     */
    public function notify(Request $request)
    {
        Log::info('Worldpay Webhook Received:', $request->all());
        return response('OK', 200);
    }
}