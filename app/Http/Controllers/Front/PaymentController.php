<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

use App\Models\Order;
use App\Models\OrderItem;

use App\Services\StuartService;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\UserAddress;
use App\Services\WorldpayService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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


    public function pay(Request $request)
    {

       
        

        $request->validate([

            'restaurant_id' => 'required',

            'amount' => 'required',
            

        ]);

        $address = null;

        if ($request->order_type == 'dine_in') {

            $address = UserAddress::where('user_id', Auth::id())
                ->where('is_default', 1)
                ->first();

            if (!$address) {
                $address = UserAddress::where('user_id', Auth::id())
                    ->latest()
                    ->first();
            }

            if (!$address) {
                return redirect()
                    ->route('profile') // change to your profile route
                    ->with('error', 'Please Complete your profile before making a payment.');
            }
        }

        $restaurant = Restaurant::findOrFail(
            $request->restaurant_id
        );

        try {

            /*
            |---------------------------------------------------
            | Login
            |---------------------------------------------------
            */

            $token = $this->worldpay->login($restaurant);

            

            /*
            |---------------------------------------------------
            | Generate HPP
            |---------------------------------------------------
            */

            $reference = 'HYST-' . strtoupper(Str::random(12));

            $hpp = $this->worldpay->generateHostedPayment(

                $restaurant,

                $token,

                [

                    'reference' => $reference,

                    'description' => 'Online Order',

                    'amount' => $request->amount,

                    'user_id' => Auth::id(),

                    'name' => Auth::user()->name,

                    'email' => Auth::user()->email,

                    'phone' => $request->phone ?? Auth::user()->phone,

                    // 'address' => $request->address ?? Auth::user()->address,

                    // 'postcode' => $request->postcode ?? Auth::user()->postcode,

                    // 'state' => Auth::user()->state,

                    // 'country' => Auth::user()->country,
                    'address' => $request->order_type == 'dine_in'
                        ? $address->address
                        : ($request->address ?? Auth::user()->address),

                    'postcode' => $request->order_type == 'dine_in'
                        ? $address->postcode
                        : ($request->postcode ?? Auth::user()->postcode),

                    'state' => $request->order_type == 'dine_in'
                        ? $address->state
                        : Auth::user()->state,

                    'country' => $request->order_type == 'dine_in'
                        ? $address->country
                        : Auth::user()->country,


                ]

            );

            /*
            |---------------------------------------------------
            | Save Payment
            |---------------------------------------------------
            */

            Payment::create([
                'restaurant_id'   => $restaurant->id,
                'transaction_id'  => $hpp['token'],   // webPageToken
                'amount'          => $request->amount,
                'payment_status'  => 'pending',
                'payment_method'  => 'online',
                'user_id'         => Auth::id(),
                'checkout_data'   => json_encode($request->all()),
            ]);

            

            return redirect()->away(
                $hpp['redirectToUrl']
            );

        } catch (\Exception $e) {

        

            \Log::error($e->getMessage());

            return back()->with(

                'error',

                $e->getMessage()

            );
        }
    }

    public function callback(Request $request)
    {
        $payment = Payment::where(
            'transaction_id',
            $request->webPageToken
        )->firstOrFail();

        $restaurant = Restaurant::findOrFail($payment->restaurant_id);

        $accessToken = $this->worldpay->login($restaurant);

        $result = $this->worldpay->getHostedPaymentStatus(
            $restaurant,
            $accessToken,
            $request->webPageToken
        );


        if($result['status'] != 'PROCESSED_SUCCESSFUL'){

            $payment->update([

                'payment_status'=>'failed'

            ]);

            return redirect()->route('checkout.failed');

        }

        if ($result['status'] === 'PROCESSED_SUCCESSFUL') {

            $payment->update([
                'payment_status' => 'paid'
            ]);

            $data = json_decode(

                $payment->checkout_data,

                true

            );

            $newRequest = new Request($data);


            app(OrderController::class)

            ->placeOrder(

                $newRequest,

                $payment

            );

            return view('front.checkout-success', compact('payment','result'));
        }

        $payment->update([
            'payment_status' => 'failed'
        ]);

        return redirect()->route('checkout.failed');
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
    

    // public function pay(Request $request)
    // {

    

    //     $restaurant = Restaurant::findOrFail(
    //         $request->restaurant_id
    //     );

    //     // dd($restaurant);
    //     $merchantTransactionId = 'TXN' . time();
    //     $amount = "1.00";
    //     $currency = "GBP";

    //     // $memberId = env('TRANSACTWORLD_MEMBER_ID');
    //     $memberId = $restaurant->transactworld_member_id;
    //     $totype = env('TRANSACTWORLD_TOTYPE');
    //     $merchantRedirectUrl = env('TRANSACTWORLD_REDIRECT_URL');
    //     // $secureKey = env('TRANSACTWORLD_CHECKSUM_KEY');
    //     $secureKey = $restaurant->transactworld_checksum_key;

    //     $checksumString = "{$memberId}|{$totype}|{$amount}|{$merchantTransactionId}|{$merchantRedirectUrl}|{$secureKey}";
    //     $checksum = md5($checksumString);
    //     $data = [
    //         'memberId' => $memberId,
    //         'language' => env('TRANSACTWORLD_LANGUAGE'),
    //         'checksum' => $checksum,
    //         'totype' => $totype,
    //         'merchantTransactionId' => $merchantTransactionId,
    //         'amount' => $amount,
    //         'TMPL_AMOUNT' => $amount,
    //         'orderDescription' => 'Test Transaction',
    //         'merchantRedirectUrl' => $merchantRedirectUrl,
    //         'notificationUrl' => env('TRANSACTWORLD_NOTIFICATION_URL'),
    //         'country' => 'UK',
    //         'city' => 'Aston',
    //         'state' => 'NA',
    //         'postcode' => 'CR2 6XH',
    //         'street' => '19 Scrimshire Lane',
    //         'telnocc' => '+44',
    //         'phone' => '07730432996',
    //         'email' => 'john.d@domain.com',
    //         'ip' => $request->ip(),
    //         'currency' => $currency,
    //         'TMPL_CURRENCY' => $currency,
    //         'reservedField1' => ''
    //     ];
    //     return view('payment.redirect', compact('data'));
    // }


    //     public function pay(Request $request)
// {
//     $request->validate([

    //         'order_type' => 'required',

    //         'payment_method' => 'required',

    //         'phone' => 'required',

    //         'address' => 'required',

    //         'pincode' => 'required',

    //     ]);

    //     $cart = session()->get('cart', []);

    //     if (empty($cart)) {

    //         return back();
//     }

    //     $total = 0;

    //     foreach ($cart as $item) {

    //         $total +=
//             $item['price']
//             * $item['quantity'];
//     }

    //     $restaurantId =
//         \App\Models\Product::find(
//             array_key_first($cart)
//         )->restaurant_id;

    //     $merchantTransactionId =
//         'TXN' . time();

    //     /*
//     |--------------------------------------------------------------------------
//     | SAVE SESSION
//     |--------------------------------------------------------------------------
//     */

    //     session()->put('payment_data', [

    //         'user_id' => auth()->id(),

    //         'restaurant_id' =>
//             $restaurantId,

    //         'cart' => $cart,

    //         'total' => $total,

    //         'order_type' =>
//             $request->order_type,

    //         'phone' =>
//             $request->phone,

    //         'address' =>
//             $request->address,

    //         'pincode' =>
//             $request->pincode,

    //         'payment_method' =>
//             $request->payment_method,

    //         'transaction_id' =>
//             $merchantTransactionId

    //     ]);

    //     $amount =
//         number_format(
//             $total,
//             2,
//             '.',
//             ''
//         );

    //     $currency = "GBP";

    //     $memberId =
//         env('TRANSACTWORLD_MEMBER_ID');

    //     $totype =
//         env('TRANSACTWORLD_TOTYPE');

    //     $merchantRedirectUrl =
//         env('TRANSACTWORLD_REDIRECT_URL');

    //     $secureKey =
//         env('TRANSACTWORLD_CHECKSUM_KEY');

    //     $checksumString =
//         "{$memberId}|{$totype}|{$amount}|{$merchantTransactionId}|{$merchantRedirectUrl}|{$secureKey}";

    //     $checksum = md5($checksumString);

    //     $data = [

    //         'memberId' => $memberId,

    //         'language' =>
//             env('TRANSACTWORLD_LANGUAGE'),

    //         'checksum' => $checksum,

    //         'totype' => $totype,

    //         'merchantTransactionId' =>
//             $merchantTransactionId,

    //         'amount' => $amount,

    //         'TMPL_AMOUNT' => $amount,

    //         'orderDescription' =>
//             'Restaurant Order',

    //         'merchantRedirectUrl' =>
//             $merchantRedirectUrl,

    //         'notificationUrl' =>
//             env('TRANSACTWORLD_NOTIFICATION_URL'),

    //         'currency' => $currency,

    //         'TMPL_CURRENCY' => $currency,

    //         'email' =>
//             auth()->user()->email,

    //         'phone' =>
//             $request->phone,

    //         'ip' => $request->ip(),
//     ];

    //     return view(
//         'payment.redirect',
//         compact('data')
//     );
// }

    // After payment redirect
    public function success(Request $request)
    {
        // Log entire response for debugging
        \Log::info('TransactWorld Response:', $request->all());

        // Get key parameters from TransactWorld callback
        $transactionId = $request->input('merchantTransactionId');
        $status = $request->input('status'); // Y = success, N = failed
        $checksum = $request->input('checksum');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $payment = DB::table('payments')->where('transaction_id', $transactionId)->first();

        if ($status == 'N') {
            \Log::error('Payment not found for Transaction ID: ' . $transactionId);
            return view('payment.failed', ['reason' => 'Payment not found']);
        }

        if (empty($payment)) {
            \Log::error('Payment not found for Transaction ID: ' . $transactionId);
            return view('payment.failed', ['reason' => 'Payment not found']);
        }

        Payment::where('transaction_id', $transactionId)->update(['status' => 1]);

        DB::table('payments')->where('transaction_id', $transactionId)->update(['status' => 1]);
        DB::table('paymentstudents')->where('transaction_id', $transactionId)->update(['status' => 1]);

        // ✅ Step 5: Fetch full payment details for emails
        $paymentStudent = DB::table('paymentstudents')
            ->select(
                'paymentstudents.*',
                'studentregistrations.*',
                'bookings.*',
                'subjects.name as subject_name'
            )
            ->join('bookings', 'bookings.s_uid', '=', 'paymentstudents.student_id')
            ->join('studentregistrations', 'studentregistrations.id', '=', 'paymentstudents.student_id')
            ->join('subjects', 'subjects.id', '=', 'paymentstudents.subject_id')
            ->where('paymentstudents.transaction_id', $transactionId)
            ->first();


        $paymentDetail = DB::table('payments')
            ->where('transaction_id', $transactionId)
            ->first();



        // ✅ Step 6: Send email to student
        $studentMailData = [
            'name' => $paymentStudent->name ?? null,
            'phone' => $paymentStudent->mobile ?? null,
            'email' => $paymentStudent->email ?? null,
            'classpuchased' => $paymentStudent->classes_purchased ?? 1,
            'postcode' => $paymentStudent->subject_name ?? "Test",
            'transaction_id' => $paymentStudent->transaction_id ?? null,
            'total_amount' => $paymentDetail->amount ?? 1,
            'mailtype' => 8,
        ];

        if (isset($paymentStudent->email) && !empty($paymentStudent->email)) {
            Mail::to($paymentStudent->email)->send(new SendMail($studentMailData));
        }

        $adminMailData = [
            'name' => $paymentStudent->name ?? null,
            'phone' => $paymentStudent->mobile ?? null,
            'email' => $paymentStudent->email ?? null,
            'classpuchased' => $paymentStudent->classes_purchased ?? 1,
            'postcode' => $paymentStudent->subject_name ?? "Test",
            'transaction_id' => $paymentStudent->transaction_id ?? null,
            'licence' => $paymentStudent->licence ?? null,
            'pass_theory' => $paymentStudent->pass_theory ?? null,
            'prefered_test_center' => $paymentStudent->prefered_test_center ?? null,
            'total_amount' => $paymentDetail->amount,
            'mailtype' => 7,
        ];

        Mail::to('7daysinstructors@gmail.com')->send(new SendMail($adminMailData));
        return view('payment.success', compact('transactionId'));
    }

    //     public function success(Request $request)
// {
//     \Log::info(
//         'PAYMENT RESPONSE',
//         $request->all()
//     );

    //     $status =
//         $request->status;

    //     $transactionId =
//         $request->merchantTransactionId;

    //     if ($status != 'Y') {

    //         return view('payment.failed');
//     }

    //     $paymentData =
//         session()->get('payment_data');

    //     if (!$paymentData) {

    //         return redirect('/');
//     }

    //     /*
//     |--------------------------------------------------------------------------
//     | CREATE ORDER
//     |--------------------------------------------------------------------------
//     */

    //     $order = Order::create([

    //         'user_id' =>
//             $paymentData['user_id'],

    //         'restaurant_id' =>
//             $paymentData['restaurant_id'],

    //         'total_amount' =>
//             $paymentData['total'],

    //         'order_type' =>
//             $paymentData['order_type'],

    //         'phone' =>
//             $paymentData['phone'],

    //         'address' =>
//             $paymentData['address'],

    //         'pincode' =>
//             $paymentData['pincode'],

    //         'payment_method' =>
//             $paymentData['payment_method'],

    //         'status' => 'confirmed'

    //     ]);

    //     /*
//     |--------------------------------------------------------------------------
//     | ORDER ITEMS
//     |--------------------------------------------------------------------------
//     */

    //     foreach ($paymentData['cart'] as $item) {

    //         OrderItem::create([

    //             'order_id' => $order->id,

    //             'product_id' => $item['id'],

    //             'quantity' => $item['quantity'],

    //             'price' => $item['price'],

    //             'total' =>
//                 $item['price']
//                 * $item['quantity']
//         ]);
//     }

    //     /*
//     |--------------------------------------------------------------------------
//     | PAYMENT ENTRY
//     |--------------------------------------------------------------------------
//     */

    //     Payment::create([

    //         'order_id' => $order->id,

    //         'restaurant_id' =>
//             $paymentData['restaurant_id'],

    //         'user_id' =>
//             $paymentData['user_id'],

    //         'payment_method' =>
//             $paymentData['payment_method'],

    //         'transaction_id' =>
//             $transactionId,

    //         'amount' =>
//             $paymentData['total'],

    //         'payment_status' => 'paid'
//     ]);

    //     /*
//     |--------------------------------------------------------------------------
//     | STUART DELIVERY
//     |--------------------------------------------------------------------------
//     */

    //     if (
//         $paymentData['order_type']
//         == 'delivery'
//     ) {

    //         $restaurant = Restaurant::find(
//             $paymentData['restaurant_id']
//         );

    //         $stuart = new StuartService();

    //         $order->load('user');

    //         $delivery =
//             $stuart->createDelivery(
//                 $order,
//                 $restaurant
//             );

    //         $order->update([

    //             'stuart_job_id' =>
//                 $delivery['id'] ?? null,

    //             'tracking_url' =>
//                 $delivery['deliveries'][0]['tracking_url']
//                 ?? null,

    //             'delivery_status' =>
//                 $delivery['status']
//                 ?? 'pending',
//         ]);
//     }

    //     session()->forget([
//         'cart',
//         'payment_data'
//     ]);

    //     return redirect('/my-orders')
//         ->with(
//             'success',
//             'Payment Successful & Order Created'
//         );
// }


    public function successpage(Request $request)
    {
        $all = $request->all();
        return view('payment.success', ['response' => $request->all()]);
    }

    public function notify(Request $request)
    {
        \Log::info('TransactWorld Notification:', $request->all());
        return response('OK', 200);
    }
}