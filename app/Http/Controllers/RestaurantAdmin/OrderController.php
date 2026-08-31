<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Message;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Services\FirebaseNotificationService;
use Illuminate\Support\Facades\Http;
use App\Models\OrderCompletionEvidence;
use App\Services\WorldpayService;
use App\Services\UberService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class OrderController extends Controller
{
    protected WorldpayService $worldpay;

    public function __construct(WorldpayService $worldpay)
    {
        $this->worldpay = $worldpay;
    }
    /*
    |--------------------------------------------------------------------------
    | ORDER LIST
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $orders = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->latest()
            ->get();

        return view(
            'restaurant.orders.index',
            compact('orders')
        );
    }

    // public function allOrders()
    // {
    //     $orders = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )
    //         ->latest()
    //         ->get();

    //     return view(
    //         'restaurant.orders.create',
    //         compact('orders')
    //     );
    // }

    public function allOrders(Request $request)
    {
        $search = $request->search;

        $orders = Order::with('user')
            ->where('restaurant_id', auth()->user()->restaurant_id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('total_amount', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'restaurant.orders.create',
            compact('orders', 'search')
        );
    }




    public function uploadEvidence(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp',
            'description' => 'required|string|max:1000',
        ]);

        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )->findOrFail($id);

        // allow only one upload
        $exists = OrderCompletionEvidence::where(
            'order_id',
            $order->id
        )->where(
            'uploader_type',
            'restaurant'
        )->exists();

        if ($exists) {
            return back()->with(
                'error',
                'Evidence already uploaded.'
            );
        }

        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();

        $request->file('photo')->move(
            public_path('order-evidence'),
            $photoName
        );

        $photo = 'order-evidence/' . $photoName;

        OrderCompletionEvidence::create([
            'order_id'      => $order->id,
            'uploader_type' => 'restaurant',
            'photo'         => $photo,
            'description'   => $request->description,
        ]);

        sendNotification(
            $order->user_id,
            'restaurant_evidence',
            'Restaurant Uploaded Evidence',
            'Restaurant uploaded delivery evidence for order #' . $order->id,
            'order',
            $order->id,
            $order->id
        );

        sendNotification(
            auth()->id(),
            'evidence_uploaded',
            'Evidence Uploaded',
            'Evidence uploaded successfully for order #' . $order->id,
            'order',
            $order->id,
            $order->id
        );
        return back()->with(
            'success',
            'Evidence uploaded successfully.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER DETAILS
    |--------------------------------------------------------------------------
    */

    // public function show($id)
    // {
    //     $order = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )
    //         ->with([
    //             'user',
    //             'items.product',
    //             'payment'
    //         ])
    //         ->findOrFail($id);

    //     return view(
    //         'restaurant.orders.show',
    //         compact('order')
    //     );
    // }

    public function show($id)
    {
        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
        ->with([
            'user',
            'restaurant',
            'items.product',
            'items.addons',
            'payment',
            'review',
            'invoice',
            'loyaltyReward',
            'earnedLoyaltyReward'
        ])
        ->findOrFail($id);

        $complaints = Complaint::where('order_id', $order->id)
        ->latest()
        ->get();

        $restaurantEvidence = OrderCompletionEvidence::where(
            'order_id',
            $order->id
        )->where(
            'uploader_type',
            'restaurant'
        )->first();
		
		$customerEvidence = OrderCompletionEvidence::where(
			'order_id',
			$order->id
		)->where(
			'uploader_type',
			'customer'
		)->first();

        return view(
            'restaurant.orders.show',
            compact('order','complaints','restaurantEvidence' , 'customerEvidence')
        );
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([

            'message' => 'required'

        ]);

        $order = Order::findOrFail($id);

        $message = Message::create([

            'sender_id' => auth()->id(),

            'receiver_id' => $order->user_id,

            'order_id' => $order->id,

            'message' => $request->message,

            'is_read' => 0

        ]);

        sendNotification(

            $order->user_id,

            'new_message',

            'New Message From Restaurant',

            'You received a new message regarding order #' .
            $order->id,

            'order',

            $order->id,

            $order->id
        );

        return back()->with(
            'success',
            'Message Sent Successfully'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS
    |--------------------------------------------------------------------------
    */

    // public function updateStatus(Request $request, $id)
    // {
    //     $order = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )
    //     ->findOrFail($id);

    //     $order->update([

    //         'status' => $request->status

    //     ]);

    //     return back()->with(
    //         'success',
    //         'Order Status Updated'
    //     );
    // }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
            ->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER STATUS
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'status' => 'required',
            'cancel_reason' => 'required_if:status,cancelled|max:500',
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->status === 'cancelled') {
            $data['cancel_reason'] = $request->cancel_reason;
            $data['cancelled_by'] = 'restaurant';
            $data['delivery_status'] = 'canceled';
            $data['uber_delivery_status'] = 'canceled';

            if (!empty($order->uber_delivery_id) && $order->uber_delivery_status !== 'canceled') {
                try {
                    $uber = new UberService();
                    $uber->cancelDelivery($order->uber_delivery_id, $request->cancel_reason ?? 'Restaurant cancelled order');
                } catch (\Throwable $e) {
                    Log::error('Uber Cancel Delivery Failed in RestaurantAdmin OrderController', [
                        'order_id' => $order->id,
                        'uber_delivery_id' => $order->uber_delivery_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        $order->update($data);



        // $order->update([

        //     'status' => $request->status,

        // ]);

        $statusMessages = [

            'pending' => 'Your order has been placed.',

            'accepted' => 'Restaurant accepted your order.',

            'completed' => 'Your order has been completed.',

            'cancelled' => 'Your order has been cancelled.',
        ];

        sendNotification(

            $order->user_id,

            'order_status',

            'Order Update',

            $statusMessages[$request->status]
                ?? ('Order status changed to ' . $request->status),

            'order',

            $order->id,

            $order->id
        );

        if ($order->user && !empty($order->user->fcm_token)) {
            Log::info('SEND ORDER STATUS FCM TO USER', ['user_id' => $order->user_id, 'status' => $request->status]);

            $title = 'Order Status Update';
            $body = 'Your order #' . $order->id . ' status is now ' . strtoupper($request->status) . '.';

            if (in_array(strtolower($request->status), ['accepted', 'preparing'])) {
                $title = 'Order Accepted! 🍳';
                $body = 'Your order #' . $order->id . ' has been accepted by the restaurant and is now being prepared!';
            } elseif (in_array(strtolower($request->status), ['completed', 'delivered'])) {
                $title = 'Order Received! 🍽️';
                $body = 'Your order #' . $order->id . ' has been delivered. Enjoy your meal!';
            } elseif (strtolower($request->status) == 'cancelled') {
                $title = 'Order Cancelled';
                $body = 'Your order #' . $order->id . ' was cancelled by the restaurant.';
            }

            $firebase = new FirebaseNotificationService();
            $firebase->send($order->user->fcm_token, $title, $body, '/my-orders');
        }
       


        /*
        |--------------------------------------------------------------------------
        | CANCELLED ORDER
        |--------------------------------------------------------------------------
        */

                /*
        |--------------------------------------------------------------------------
        | CANCELLED ORDER
        |--------------------------------------------------------------------------
        */

        if ($request->status === 'cancelled') {

            $payment = $order->payment;

            if (
                $payment &&
                !empty($payment->payment_transaction_id) &&
                !in_array($payment->payment_status, ['refunded'])
            ) {
                try {

                    $restaurant = $order->restaurant;

                    $token = $this->worldpay->login($restaurant);

                    // Refund FULL amount
                    $this->worldpay->refundPayment(
                        $restaurant,
                        $token,
                        $payment->payment_transaction_id,
                        $payment->amount, // Full payment amount
                        $payment->payment_type,
                        "Full refund for cancelled Order #{$order->id}"
                    );

                    DB::transaction(function () use ($payment) {

                        $payment->refunded_amount = $payment->amount;

                        $payment->payment_status = 'refunded';

                        $payment->save();

                    });

                } catch (\Exception $e) {

                    Log::error('Refund Failed', [
                        'order_id' => $order->id,
                        'message' => $e->getMessage()
                    ]);

                    return back()->with(
                        'error',
                        'Order was cancelled but refund failed: ' . $e->getMessage()
                    );
                }
            }
        }



        return back()->with(
            'success',
            'Order Status Updated Successfully'
        );
    }

    public function updatePaymentStatus(
        Request $request,
        $id
    ) {
        $order = Order::where(

            'restaurant_id',
            auth()->user()->restaurant_id

        )->findOrFail($id);

        Payment::where(

            'order_id',
            $order->id

        )->update([

                    'payment_status' =>
                        $request->payment_status

                ]);

        sendNotification(

            $order->user_id,

            'payment_status',

            'Payment Status Updated',

            'Payment status for order #' .
            $order->id .
            ' changed to ' .
            ucfirst($request->payment_status),

            'order',

            $order->id,

            $order->id
        );        
        

        return back()->with(

            'success',

            'Payment Status Updated Successfully'

        );
    }

    // public function refundPayment($id)
    // {
    //     $order = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )->with('payment')->findOrFail($id);

    //     if ($order->status !== 'cancelled') {

    //         return back()->with(
    //             'error',
    //             'Only cancelled orders can be refunded.'
    //         );
    //     }

    //     if (!$order->payment) {

    //         return back()->with(
    //             'error',
    //             'Payment record not found.'
    //         );
    //     }

    //     if ($order->payment->payment_status !== 'paid') {

    //         return back()->with(
    //             'error',
    //             'Only paid orders can be refunded.'
    //         );
    //     }

    //     $order->payment->update([
    //         'payment_status' => 'refunded'
    //     ]);

    //     return back()->with(
    //         'success',
    //         'Payment Refunded Successfully.'
    //     );
    // }

    public function refundPayment(Request $request, $id)
    {
        $order = Order::where(
            'restaurant_id',
            auth()->user()->restaurant_id
        )
        ->with('payment')
        ->findOrFail($id);

        if ($order->status !== 'cancelled') {
            return back()->with(
                'error',
                'Only cancelled orders can be refunded.'
            );
        }

        if (!$order->payment) {
            return back()->with(
                'error',
                'Payment record not found.'
            );
        }

        $payment = $order->payment;

        $request->validate([
            'refund_amount' => 'required|numeric|min:0.01'
        ]);

        $alreadyRefunded = $payment->refunded_amount ?? 0;

        $remainingAmount =
            $order->total_amount - $alreadyRefunded;

        if ($request->refund_amount > $remainingAmount) {

            return back()->with(
                'error',
                'Refund amount exceeds remaining balance.'
            );
        }

        $newRefundedAmount =
            $alreadyRefunded + $request->refund_amount;

        $status = 'partially_refunded';

        if ($newRefundedAmount >= $order->total_amount) {
            $status = 'refunded';
        }

        $payment->update([
            'refunded_amount' => $newRefundedAmount,
            'payment_status'  => $status,
        ]);

        sendNotification(

            $order->user_id,

            'refund_processed',

            $status == 'refunded'
                ? 'Full Refund Processed'
                : 'Partial Refund Processed',

            $status == 'refunded'

                ? 'A full refund of £' .
                    number_format($newRefundedAmount, 2) .
                    ' has been processed for order #' .
                    $order->id

                : 'A partial refund of £' .
                    number_format($request->refund_amount, 2) .
                    ' has been processed for order #' .
                    $order->id .
                    '. Total refunded: £' .
                    number_format($newRefundedAmount, 2),

            'order',

            $order->id,

            $order->id
        );

        sendNotification(

            auth()->id(),

            'refund_processed',

            'Refund Processed',

            'Refund of £' .
            number_format($request->refund_amount, 2) .
            ' processed for order #' .
            $order->id,

            'order',

            $order->id,

            $order->id
        );

        return back()->with(
            'success',
            'Refund processed successfully.'
        );
    }
  
    // public function refundPayment($id)
    // {
    //     $order = Order::where(
    //         'restaurant_id',
    //         auth()->user()->restaurant_id
    //     )
    //     ->with([
    //         'payment',
    //         'restaurant'
    //     ])
    //     ->findOrFail($id);

    //     if ($order->status !== 'cancelled') {

    //         return back()->with(
    //             'error',
    //             'Only cancelled orders can be refunded.'
    //         );
    //     }

    //     if (!$order->payment) {

    //         return back()->with(
    //             'error',
    //             'Payment record not found.'
    //         );
    //     }

    //     if ($order->payment->payment_status !== 'paid') {

    //         return back()->with(
    //             'error',
    //             'Only paid payments can be refunded.'
    //         );
    //     }

    //     $restaurant = $order->restaurant;

    //     $memberId =
    //         $restaurant->transactworld_member_id;

    //     $secureKey =
    //         $restaurant->transactworld_checksum_key;

    //     $paymentId =
    //         $order->payment->payment_id;

    //     $amount = number_format(
    //         $order->payment->amount,
    //         2,
    //         '.',
    //         ''
    //     );

    //     $checksum = md5(
    //         $memberId .
    //         '|' .
    //         $secureKey .
    //         '|' .
    //         $paymentId .
    //         '|' .
    //         $amount
    //     );

    //     $endpoint =
    //         'https://preprod.transactworld.com/transactionServices/REST/v1/payments/' .
    //         $paymentId;

    //     $response = Http::withHeaders([

    //         'Content-Type' => 'application/json',

    //         // Add auth token here
    //         'authentication' =>
    //             'YOUR_AUTH_TOKEN'

    //     ])->post($endpoint, [

    //         'memberId' =>
    //             $memberId,

    //         'paymentType' =>
    //             'RF',

    //         'amount' =>
    //             $amount,

    //         'checksum' =>
    //             $checksum
    //     ]);

    //     $result = $response->json();

    //     \Log::info('Refund Response', $result);

    //     if (
    //         isset($result['responseCode']) &&
    //         $result['responseCode'] == '000'
    //     ) {

    //         $order->payment->update([

    //             'payment_status' =>
    //                 'refunded'
    //         ]);

    //         return back()->with(
    //             'success',
    //             'Payment Refunded Successfully.'
    //         );
    //     }

    //     return back()->with(
    //         'error',
    //         $result['responseMessage']
    //             ?? 'Refund Failed'
    //     );
    // }

    public function reviews()
    {
        $reviews = Review::with([

            'user',
            'order'

        ])

            ->where(

                'restaurant_id',

                auth()->user()->restaurant_id

            )

            ->latest()

            ->get();

        return view(

            'restaurant.reviews.index',

            compact('reviews')

        );
    }
    public function approveReview($id)
    {
        $review = Review::findOrFail($id);

        $review->update([

            'status' => 'approved'

        ]);

        return back()->with(

            'success',

            'Review approved successfully.'

        );
    }
    public function rejectReview($id)
    {
        $review = Review::findOrFail($id);

        $review->update([

            'status' => 'rejected'

        ]);

        return back()->with(

            'success',

            'Review rejected successfully.'

        );
    }
}