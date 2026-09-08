<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ReferralUsage;
use App\Services\ReferralService;

class UserDashboardController extends Controller
{
    public function index(Request $request)
    {
        savePageVisit($request, 'User Dashboard');

        $user = auth()->user();

        $orders = Order::where('user_id', $user->id)->count();

        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $unreadCount = \App\Models\Notification::where('user_id', $user->id)
            ->where('is_read', 0)
            ->count();

        $referralService = app(ReferralService::class);
        $referralCode = $referralService->getOrCreateCodeForUser($user);

        $referralStats = [
            'total_referrals' => ReferralUsage::where('referrer_id', $user->id)->where('status', 'completed')->count(),
            'total_earned' => ReferralUsage::where('referrer_id', $user->id)->where('status', 'completed')->sum('referrer_reward_amount'),
        ];

        return view('front.dashboard', compact('orders', 'notifications', 'unreadCount', 'referralCode', 'referralStats'));
    }
}