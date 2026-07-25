<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Complaint;
use App\Models\Message;
use App\Models\OrderCompletionEvidence;
use App\Models\ComplaintMessage;


class ComplaintController extends Controller
{
  
            public function index(Request $request)
            {
                $search = $request->search;

                $orders = Order::with(['user', 'restaurant', 'complaints'])
                    ->whereHas('complaints')
                    ->when($search, function ($query) use ($search) {
                        $query->where(function ($q) use ($search) {
                            $q->where('id', 'like', "%{$search}%")
                                ->orWhereHas('user', function ($user) use ($search) {
                                    $user->where('name', 'like', "%{$search}%");
                                })
                                ->orWhereHas('restaurant', function ($restaurant) use ($search) {
                                    $restaurant->where('name', 'like', "%{$search}%");
                                });
                        });
                    })
                    ->latest()
                    ->paginate(10);

                return view('admin.complaint.index', compact('orders', 'search'));
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
                    'restaurant',
                    'resolver',
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
                        'admin.complaint.show',
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

                $complaint = Complaint::findOrFail($id);

                ComplaintMessage::create([
                    'complaint_id'=>$complaint->id,
                    'sender_id'=>auth()->id(),
                    'sender_type'=>'admin',
                    'message'=>$request->message
                ]);

                $complaint->update([
                    'status'=>'admin_replied'
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

                return back()->with('success','Reply Sent Successfully');
            }

            public function changeStatus(Request $request,$id)
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

                return back()->with('success','Complaint Status Updated Successfully.');
            }

            public function resolve($id)
            {
                $complaint = Complaint::findOrFail($id);

                $complaint->update([

                    'status'=>'resolved',

                    'resolved_by'=>auth()->id(),

                    'resolved_at'=>now()

                ]);

                sendNotification(

                    $complaint->user_id,

                    'complaint_resolved',

                    'Complaint Resolved',

                    'Your complaint has been resolved.',

                    'complaint',

                    $complaint->id,

                    $complaint->order_id

                );

                return back()->with('success','Complaint Resolved');
            }

            public function reject(Request $request,$id)
            {
                $request->validate([
                    'note'=>'nullable'
                ]);

                $complaint = Complaint::findOrFail($id);

                $complaint->update([

                    'status'=>'rejected',

                    'resolved_by'=>auth()->id(),

                    'resolved_at'=>now(),

                    'resolution_note'=>$request->note

                ]);

                sendNotification(

                    $complaint->user_id,

                    'complaint_rejected',

                    'Complaint Rejected',

                    'Your complaint has been rejected.',

                    'complaint',

                    $complaint->id,

                    $complaint->order_id

                );

                return back()->with('success','Complaint Rejected');
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