<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function clear($id)
    {
        $notification = Notification::where('user_id',auth()->id())
        ->with('order')
        ->findOrFail($id);

        if ($notification->order &&
            $notification->order->status === 'pending') {

            return back()->with(
                'error',
                'Pending order notifications cannot be removed.'
            );
        }

        $notification->delete();


        return back();
    }

    public function clearAll()
    {
        Notification::where('user_id',auth()->id())
        ->where(function ($query) {
            $query->whereNull('order_id')
                ->orWhereDoesntHave('order', function ($q) {
                    $q->where('status', 'pending');
                });
        })
        ->delete();

        return back();
    }

    public function markAsRead($id)
    {
        Notification::where(
            'user_id',
            auth()->id()
        )
        ->where('id', $id)
        ->update([
            'is_read' => 1
        ]);

        return back();
    }

    public function markAllAsRead()
    {
        Notification::where(
            'user_id',
            auth()->id()
        )
        ->update([
            'is_read' => 1
        ]);

        return back();
    }

    public function latest()
    {
        if (!auth()->check()) {

            return response()->json([
                'notifications' => [],
                'unreadCount' => 0
            ]);
        }

        $notifications = Notification::where('user_id', auth()->id())
            ->with(['user', 'order'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {

                return [
                    'id'             => $notification->id,
                    'title'          => $notification->title,
                    'message'        => $notification->message,
                    'type'           => $notification->type,
                    'order_id'       => $notification->order_id,
                    'reference_id'   => $notification->reference_id,
                    'reference_type' => $notification->reference_type,
                    'is_read'        => $notification->is_read,
                    'created_at'     => $notification->created_at,

                    // Show clear button only if order is not pending
                    'can_clear' => !(
                        $notification->order &&
                        strtolower($notification->order->status) === 'pending'
                    ),
                ];
            });

        $unreadCount = Notification::where('user_id', auth()->id())
            ->where('is_read', 0)
            ->count();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount
        ]);
    }
}