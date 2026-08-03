<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\RestaurantLoyaltyRule;
use App\Models\UserLoyaltyReward;
use Illuminate\Http\Request;

class LoyaltyRuleController extends Controller
{
    public function index()
    {
        $restaurantId = auth()->user()->restaurant_id;

        $rule = RestaurantLoyaltyRule::where('restaurant_id', $restaurantId)->first();

        $stats = [
            'total_issued' => UserLoyaltyReward::where('restaurant_id', $restaurantId)->count(),
            'active_rewards' => UserLoyaltyReward::where('restaurant_id', $restaurantId)
                ->where('status', 'active')
                ->where('expires_at', '>=', now())
                ->count(),
            'redeemed_rewards' => UserLoyaltyReward::where('restaurant_id', $restaurantId)
                ->where('status', 'used')
                ->count(),
            'total_discount_given' => UserLoyaltyReward::where('restaurant_id', $restaurantId)
                ->where('status', 'used')
                ->sum('reward_amount'),
        ];

        $recentRewards = UserLoyaltyReward::with(['user', 'earnedFromOrder', 'usedInOrder'])
            ->where('restaurant_id', $restaurantId)
            ->latest()
            ->paginate(15);

        return view('restaurant.loyalty-rewards.index', compact('rule', 'stats', 'recentRewards'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'min_order_amount'  => 'required|numeric|min:0.01',
            'reward_amount'     => 'required|numeric|min:0.01',
            'expiry_days'       => 'required|integer|min:1',
            'max_uses_per_user' => 'nullable|integer|min:1',
            'is_active'         => 'nullable|boolean',
        ]);

        $restaurantId = auth()->user()->restaurant_id;

        RestaurantLoyaltyRule::updateOrCreate(
            ['restaurant_id' => $restaurantId],
            [
                'min_order_amount'  => $request->min_order_amount,
                'reward_amount'     => $request->reward_amount,
                'expiry_days'       => $request->expiry_days,
                'max_uses_per_user' => $request->max_uses_per_user,
                'is_active'         => $request->has('is_active') ? $request->boolean('is_active') : true,
            ]
        );

        return redirect()->back()->with('success', 'Loyalty reward rule updated successfully.');
    }

    public function destroy()
    {
        $restaurantId = auth()->user()->restaurant_id;

        RestaurantLoyaltyRule::where('restaurant_id', $restaurantId)->delete();

        return redirect()->back()->with('success', 'Loyalty reward rule removed.');
    }
}
