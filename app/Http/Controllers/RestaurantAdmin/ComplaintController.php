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
use App\Models\ComplaintMessage;
use Illuminate\Support\Facades\Http;
    use App\Models\OrderCompletionEvidence;


class ComplaintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ORDER LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $search = $request->search;

        $orders = Order::with('user', 'complaints')
        ->whereHas('complaints')
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
            'restaurant.complaint.index',
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
            'invoice'
        ])
        ->findOrFail($id);

        $complaints = Complaint::with([
            'user',
            'restaurant',
            'resolver',
            'messages.sender'
        ])
        ->where('order_id', $order->id)
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
            'restaurant.complaint.show',
            compact('order','complaints','restaurantEvidence' , 'customerEvidence')
        );
    }

    public function complaintReply(Request $request,$id)
{
    $request->validate([
        'message'=>'required'
    ]);

    $complaint = Complaint::findOrFail($id);

    ComplaintMessage::create([

        'complaint_id'=>$complaint->id,

        'sender_id'=>auth()->id(),

        'sender_type'=>'restaurant',

        'message'=>$request->message

    ]);

    $complaint->update([
        'status'=>'restaurant_replied'
    ]);

    sendNotification(

        $complaint->user_id,

        'complaint_reply',

        'Restaurant Reply',

        'Restaurant replied to your complaint.',

        'complaint',

        $complaint->id,

        $complaint->order_id

    );

    return back()->with('success','Reply Sent Successfully');
}

public function updateComplaintStatus(Request $request,$id)
{
    $request->validate([
        'status'=>'required'
    ]);

    $complaint = Complaint::findOrFail($id);

    $complaint->status = $request->status;

    if($request->status=='resolved')
    {
        $complaint->resolved_by = auth()->id();
        $complaint->resolved_at = now();
    }

    $complaint->save();

    sendNotification(

        $complaint->user_id,

        'complaint_status',

        'Complaint Status Updated',

        'Restaurant updated complaint status to '.ucwords(str_replace('_',' ',$request->status)),

        'complaint',

        $complaint->id,

        $complaint->order_id

    );

    return back()->with('success','Complaint Status Updated Successfully');
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