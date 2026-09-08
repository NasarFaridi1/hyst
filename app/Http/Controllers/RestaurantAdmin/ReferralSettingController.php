<?php

namespace App\Http\Controllers\RestaurantAdmin;

use App\Http\Controllers\Controller;
use App\Models\ReferralSetting;
use App\Models\ReferralUsage;
use Illuminate\Http\Request;

class ReferralSettingController extends Controller
{
    /**
     * Display referral settings for the logged in restaurant admin.
     */
    public function index(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id ?? $request->query('restaurant_id');

        $setting = ReferralSetting::firstOrCreate(
            ['restaurant_id' => $restaurantId],
            [
                'referee_discount_type' => 'fixed',
                'referee_discount_value' => 5.00,
                'min_order_amount' => 10.00,
                'referrer_reward_type' => 'fixed',
                'referrer_reward_value' => 5.00,
                'is_active' => true,
            ]
        );

        $referralUsages = ReferralUsage::with(['referrer', 'referee', 'order'])
            ->where('restaurant_id', $restaurantId)
            ->latest()
            ->paginate(15);

        $stats = [
            'completed_count' => ReferralUsage::where('restaurant_id', $restaurantId)->where('status', 'completed')->count(),
            'pending_count' => ReferralUsage::where('restaurant_id', $restaurantId)->where('status', 'pending')->count(),
            'total_rewards' => ReferralUsage::where('restaurant_id', $restaurantId)->where('status', 'completed')->sum('referrer_reward_amount'),
        ];

        if ($request->wantsJson()) {
            return response()->json([
                'status' => true,
                'data' => [
                    'setting' => $setting,
                    'usages' => $referralUsages,
                    'stats' => $stats,
                ]
            ]);
        }

        return view('restaurant.referral.index', [
            'setting' => $setting,
            'usages' => $referralUsages,
            'stats' => $stats,
        ]);
    }

    /**
     * Update referral settings.
     */
    public function update(Request $request)
    {
        $restaurantId = auth()->user()->restaurant_id ?? $request->input('restaurant_id');

        $request->validate([
            'referee_discount_type' => 'required|in:fixed,percentage',
            'referee_discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'required|numeric|min:0',
            'referrer_reward_type' => 'required|in:fixed,percentage',
            'referrer_reward_value' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);

        $setting = ReferralSetting::updateOrCreate(
            ['restaurant_id' => $restaurantId],
            [
                'referee_discount_type' => $request->referee_discount_type,
                'referee_discount_value' => $request->referee_discount_value,
                'min_order_amount' => $request->min_order_amount,
                'referrer_reward_type' => $request->referrer_reward_type,
                'referrer_reward_value' => $request->referrer_reward_value,
                'is_active' => (bool) $request->is_active,
            ]
        );

        if ($request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Referral settings updated successfully.',
                'setting' => $setting,
            ]);
        }

        return redirect()->back()->with('success', 'Referral settings updated successfully!');
    }
}
