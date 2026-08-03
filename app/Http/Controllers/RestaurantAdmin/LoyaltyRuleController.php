<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\LoyaltyReward;
use App\Models\LoyaltyRewardUsage;
use App\Models\LoyaltyRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyRuleController extends Controller
{
    /**
     * Display a listing of loyalty rules and reward stats for the restaurant.
     */
    public function index()
    {
        $restaurantId = Auth::user()->restaurant_id ?? Auth::user()->restaurant?->id;

        if (!$restaurantId) {
            return redirect()->back()->with('error', 'Restaurant profile not found.');
        }

        $rules = LoyaltyRule::where('restaurant_id', $restaurantId)
            ->latest()
            ->get();

        $stats = [
            'total_rules'     => $rules->count(),
            'active_rules'    => $rules->where('is_active', 1)->count(),
            'total_issued'    => LoyaltyReward::where('restaurant_id', $restaurantId)->count(),
            'total_redeemed'  => LoyaltyRewardUsage::whereHas('loyaltyReward', function ($q) use ($restaurantId) {
                $q->where('restaurant_id', $restaurantId);
            })->count(),
            'total_discount'  => LoyaltyRewardUsage::whereHas('loyaltyReward', function ($q) use ($restaurantId) {
                $q->where('restaurant_id', $restaurantId);
            })->sum('discount_amount'),
        ];

        $issuedRewards = LoyaltyReward::with(['user', 'earnedFromOrder', 'loyaltyRule'])
            ->where('restaurant_id', $restaurantId)
            ->latest()
            ->paginate(15);

        return view('restaurant.loyalty-rewards.index', compact('rules', 'stats', 'issuedRewards'));
    }

    /**
     * Store a newly created loyalty rule in storage.
     */
    public function store(Request $request)
    {
        $restaurantId = Auth::user()->restaurant_id ?? Auth::user()->restaurant?->id;

        $request->validate([
            'name'                 => 'required|string|max:255',
            'minimum_order_amount' => 'required|numeric|min:0.01',
            'reward_type'          => 'required|in:fixed,percentage',
            'reward_value'         => 'required|numeric|min:0.01',
            'expiry_days'          => 'required|integer|min:1',
            'max_usage'            => 'required|integer|min:1',
            'is_active'            => 'nullable|boolean',
        ]);

        LoyaltyRule::create([
            'restaurant_id'        => $restaurantId,
            'name'                 => $request->name,
            'minimum_order_amount' => $request->minimum_order_amount,
            'reward_type'          => $request->reward_type,
            'reward_value'         => $request->reward_value,
            'expiry_days'          => $request->expiry_days,
            'max_usage'            => $request->max_usage ?? 1,
            'is_active'            => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('restaurant.loyalty-rewards.index')
            ->with('success', 'Loyalty rule created successfully!');
    }

    /**
     * Update the specified loyalty rule in storage.
     */
    public function update(Request $request, $id)
    {
        $restaurantId = Auth::user()->restaurant_id ?? Auth::user()->restaurant?->id;

        $rule = LoyaltyRule::where('restaurant_id', $restaurantId)
            ->where('id', $id)
            ->firstOrFail();

        $request->validate([
            'name'                 => 'required|string|max:255',
            'minimum_order_amount' => 'required|numeric|min:0.01',
            'reward_type'          => 'required|in:fixed,percentage',
            'reward_value'         => 'required|numeric|min:0.01',
            'expiry_days'          => 'required|integer|min:1',
            'max_usage'            => 'required|integer|min:1',
            'is_active'            => 'nullable|boolean',
        ]);

        $rule->update([
            'name'                 => $request->name,
            'minimum_order_amount' => $request->minimum_order_amount,
            'reward_type'          => $request->reward_type,
            'reward_value'         => $request->reward_value,
            'expiry_days'          => $request->expiry_days,
            'max_usage'            => $request->max_usage ?? 1,
            'is_active'            => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('restaurant.loyalty-rewards.index')
            ->with('success', 'Loyalty rule updated successfully!');
    }

    /**
     * Remove the specified loyalty rule from storage.
     */
    public function destroy($id)
    {
        $restaurantId = Auth::user()->restaurant_id ?? Auth::user()->restaurant?->id;

        $rule = LoyaltyRule::where('restaurant_id', $restaurantId)
            ->where('id', $id)
            ->firstOrFail();

        $rule->delete();

        return redirect()->route('restaurant.loyalty-rewards.index')
            ->with('success', 'Loyalty rule deleted successfully!');
    }

    /**
     * Toggle the active status of a loyalty rule.
     */
    public function toggleStatus($id)
    {
        $restaurantId = Auth::user()->restaurant_id ?? Auth::user()->restaurant?->id;

        $rule = LoyaltyRule::where('restaurant_id', $restaurantId)
            ->where('id', $id)
            ->firstOrFail();

        $rule->is_active = $rule->is_active ? 0 : 1;
        $rule->save();

        return redirect()->route('restaurant.loyalty-rewards.index')
            ->with('success', 'Rule status updated successfully!');
    }
}
