<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;

class UserDashboardController extends Controller
{

    public function index()
    {
        $orders = Order::where(
            'user_id',
            auth()->id()
        )->count();

        $notifications = \App\Models\Notification::where(
            'user_id',
            auth()->id()
        )
        ->latest()
        ->take(10)
        ->get();

        $unreadCount = \App\Models\Notification::where(
            'user_id',
            auth()->id()
        )
        ->where('is_read', 0)
        ->count();

        return view('front.dashboard',
            compact('orders', 'notifications', 'unreadCount'));
    }
}