<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReferralUsage;
use App\Services\ReferralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReferralController extends Controller
{
    protected $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    /**
     * Get or create the authenticated user's referral code and stats.
     */
    public function myCode(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $restaurantId = $request->query('restaurant_id');

        $referralCode = $this->referralService->getOrCreateCodeForUser($user, $restaurantId);
        $setting = $this->referralService->getReferralSetting($restaurantId);

        $totalReferrals = ReferralUsage::where('referrer_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $totalRewardsEarned = ReferralUsage::where('referrer_id', $user->id)
            ->where('status', 'completed')
            ->sum('referrer_reward_amount');

        $shareLink = config('app.url') . '/?ref=' . $referralCode->code;

        return response()->json([
            'status' => true,
            'data' => [
                'referral_code' => $referralCode->code,
                'share_link' => $shareLink,
                'referee_discount_type' => $setting->referee_discount_type,
                'referee_discount_value' => (float) $setting->referee_discount_value,
                'referrer_reward_type' => $setting->referrer_reward_type,
                'referrer_reward_value' => (float) $setting->referrer_reward_value,
                'total_referrals' => $totalReferrals,
                'total_rewards_earned' => (float) $totalRewardsEarned,
            ]
        ]);
    }

    /**
     * Validate a referral code during cart checkout.
     */
    public function validateCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'referral_code' => 'required|string',
            'restaurant_id' => 'required|integer',
            'subtotal' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $user = auth()->user();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated.'
            ], 401);
        }

        $result = $this->referralService->validateReferralCode(
            $request->referral_code,
            $user,
            (int) $request->restaurant_id,
            (float) $request->subtotal
        );

        if (!$result['valid']) {
            return response()->json([
                'status' => false,
                'message' => $result['message'],
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => $result['message'],
            'discount_amount' => $result['discount_amount'],
            'referral_code' => $result['referral_code']->code,
        ]);
    }
}
