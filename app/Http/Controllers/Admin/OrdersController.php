<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Complaint;
use App\Models\Message;
use App\Models\OrderCompletionEvidence;
use App\Models\ComplaintMessage;


class OrdersController extends Controller
{
    // public function index()
    // {
    //     $orders = Order::latest()->get();

    //     return view('admin.orders.index',
    //         compact('orders'));
    // }

    public function index(Request $request)
    {
        $search = $request->search;

        $orders = Order::with(['user', 'restaurant'])
            ->when($search, function ($query) use ($search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('restaurant', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'search'));
    }

  public function show($id)
{
    $order = Order::with([
        'user',
        'restaurant',
        'items.product',
        'items.addons',
        'payment',
        'review',
        'invoice'
    ])->findOrFail($id);

    $complaints = Complaint::with([
        'user',
        'messages.sender'
    ])
    ->where('order_id',$order->id)
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
        'admin.orders.show',
        compact(
            'order',
            'complaints',
            'restaurantEvidence',
			'customerEvidence'
        )
    );
}
	
	public function complaintReply(Request $request,$id)
{
    $request->validate([
        'message'=>'required'
    ]);

    $complaint=Complaint::findOrFail($id);

    ComplaintMessage::create([

        'complaint_id'=>$complaint->id,

        'sender_id'=>auth()->id(),

        'sender_type'=>'admin',

        'message'=>$request->message

    ]);

    sendNotification(

        $complaint->user_id,

        'complaint_reply',

        'Admin Reply',

        'Admin replied to your complaint.',

        'complaint',

        $complaint->id,

        $complaint->order_id

    );

    return back()->with(
        'success',
        'Reply Sent Successfully'
    );
}
	public function sendMessage(Request $request, $id)
{
    $request->validate([
        'message' => 'required'
    ]);

    $order = Order::findOrFail($id);

    Message::create([
        'sender_id'   => auth()->id(),
        'receiver_id' => $order->user_id,
        'order_id'    => $order->id,
        'message'     => $request->message,
        'is_read'     => 0,
    ]);

    sendNotification(
        $order->user_id,
        'new_message',
        'New Message From Admin',
        'You received a new message regarding Order #'.$order->id,
        'order',
        $order->id,
        $order->id
    );

    return back()->with('success','Message Sent Successfully');
}

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update([

            'status' => $request->status
        ]);

        return back()->with(
            'success',
            'Order Status Updated'
        );
    }
}