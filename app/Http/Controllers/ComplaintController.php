<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\ComplaintMessage;
use App\Models\User;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Customer Create Complaint
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'subject'       => 'required|max:255',
            'complaint'     => 'required',
            'order_id'      => 'nullable',
            'product_id'    => 'nullable',
            'category'      => 'nullable',
        ]);

        $complaint =Complaint::create([
            'user_id'       => auth()->id(),
            'restaurant_id' => $request->restaurant_id,
            'order_id'      => $request->order_id,
            'product_id'    => $request->product_id,
            'subject'       => $request->subject,
            'category'      => $request->category,
            'status'        => 'Pending',
        ]);

        ComplaintMessage::create([
            'complaint_id'=>$complaint->id,
            'sender_id'=>auth()->id(),
            'sender_type'=>'customer',
            'message'=>$request->complaint
        ]);

        $restaurantAdmin = User::where('restaurant_id', $request->restaurant_id)
            ->where('role', 'restaurant_admin')
            ->first();

        if ($restaurantAdmin) {
            sendNotification(
                $restaurantAdmin->id,
                'complaint',
                'New Complaint Received',
                auth()->user()->name . ' submitted a complaint.',
                'complaint',
                $complaint->id,
                $complaint->order_id
            );
        }

        return back()->with(
            'success',
            'Complaint submitted successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Customer View Own Complaints
    |--------------------------------------------------------------------------
    */
    public function myComplaints()
    {
        $complaints = Complaint::with([
            'restaurant',
            'order',
            'product'
        ])
        ->where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->paginate(20);

        return view(
            'complaints.my',
            compact('complaints')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Restaurant Complaints
    |--------------------------------------------------------------------------
    */
    public function restaurantComplaints()
    {
        $restaurantId = auth()->user()->restaurant_id;

        $complaints = Complaint::with([
            'user',
            'order',
            'product'
        ])
        ->where(
            'restaurant_id',
            $restaurantId
        )
        ->latest()
        ->paginate(20);

        return view(
            'restaurant.complaints.index',
            compact('complaints')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Restaurant Reply
    |--------------------------------------------------------------------------
    */
    // public function reply(Request $request, $id)
    // {
    //     $request->validate([
    //         'restaurant_reply' => 'required'
    //     ]);

    //     $complaint = Complaint::findOrFail($id);

    //     ComplaintMessage::create([
    //         'complaint_id'=>$complaint->id,
    //         'sender_id'=>auth()->id(),
    //         'sender_type'=>'restaurant',
    //         'message'=>$request->restaurant_reply
    //     ]);

    //     $complaint->update([
    //         'status'=>'In Progress'
    //     ]);

    //     // $complaint->update([
    //     //     'restaurant_reply' => $request->restaurant_reply,
    //     //     'status'           => 'Restaurant Replied',
    //     //     'replied_at'       => now(),
    //     // ]);


    //     sendNotification(
    //         $complaint->user_id,
    //         'complaint_reply',
    //         'Complaint Reply',
    //         'Your complaint has been replied to by the restaurant.',
    //         'complaint',
    //         $complaint->id,
    //         $complaint->order_id
    //     );

    //     return back()->with(
    //         'success',
    //         'Reply sent successfully.'
    //     );
    // }


    public function reply(Request $request,$id)
    {
        $request->validate([
            'message'=>'required'
        ]);

        $complaint=Complaint::findOrFail($id);

        ComplaintMessage::create([
            'complaint_id'=>$complaint->id,
            'sender_id'=>auth()->id(),
            'sender_type'=>'restaurant',
            'message'=>$request->message
        ]);

        sendNotification(
            $complaint->user_id,
            'complaint_reply',
            'Complaint Reply',
            'Restaurant sent a new message.',
            'complaint',
            $complaint->id,
            $complaint->order_id
        );

        return back()->with('success','Reply sent.');
    }

    public function sendMessage(Request $request,$id)
    {
        $request->validate([
            'message'=>'required'
        ]);

        $complaint=Complaint::findOrFail($id);

        ComplaintMessage::create([
            'complaint_id'=>$complaint->id,
            'sender_id'=>auth()->id(),
            'sender_type'=>'customer',
            'message'=>$request->message
        ]);

        return back()->with('success','Message sent.');
    }
}