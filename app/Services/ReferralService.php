<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\ReferralCode;
use App\Models\ReferralSetting;
use App\Models\ReferralUsage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ReferralService
{
    /**
     * Get or generate a unique referral code for a user (optionally per restaurant).
     */
    public function getOrCreateCodeForUser(User $user, $restaurantId = null)
    {
        $query = ReferralCode::where('user_id', $user->id);

        if ($restaurantId) {
            $query->where('restaurant_id', $restaurantId);
        } else {
            $query->whereNull('restaurant_id');
        }

        $referralCode = $query->first();

        if (!$referralCode) {
            $code = $this->generateUniqueCode($user);

            $referralCode = ReferralCode::create([
                'user_id' => $user->id,
                'restaurant_id' => $restaurantId,
                'code' => $code,
                'usage_count' => 0,
                'is_active' => true,
            ]);
        }

        return $referralCode;
    }

    /**
     * Generate a clean, readable, unique referral code.
     */
    private function generateUniqueCode(User $user)
    {
        $cleanName = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $user->name ?? 'USER'));
        if (strlen($cleanName) < 3) {
            $cleanName = 'HYST';
        }
        $prefix = substr($cleanName, 0, 4);

        do {
            $randomStr = strtoupper(Str::random(4));
            $code = $prefix . '-' . $randomStr;
        } while (ReferralCode::where('code', $code)->exists());

        return $code;
    }

    /**
     * Get referral settings for a restaurant (or fallback to global settings).
     */
    public function getReferralSetting($restaurantId = null)
    {
        if ($restaurantId) {
            $setting = ReferralSetting::where('restaurant_id', $restaurantId)->where('is_active', true)->first();
            if ($setting) {
                return $setting;
            }
        }

        // Global default setting
        $setting = ReferralSetting::whereNull('restaurant_id')->where('is_active', true)->first();

        if (!$setting) {
            // Virtual default setting if none stored in DB yet
            $setting = new ReferralSetting([
                'restaurant_id' => $restaurantId,
                'referee_discount_type' => 'fixed',
                'referee_discount_value' => 5.00,
                'min_order_amount' => 10.00,
                'referrer_reward_type' => 'fixed',
                'referrer_reward_value' => 5.00,
                'is_active' => true,
            ]);
        }

        return $setting;
    }

    /**
     * Validate a referral code for checkout.
     */
    public function validateReferralCode(string $code, User $refereeUser, int $restaurantId, float $subtotal)
    {
        $code = strtoupper(trim($code));

        $referralCode = ReferralCode::where('code', $code)->where('is_active', true)->first();

        if (!$referralCode) {
            return [
                'valid' => false,
                'message' => 'Invalid or expired referral code.',
            ];
        }

        // Check if referral code is restaurant-specific
        if ($referralCode->restaurant_id && $referralCode->restaurant_id != $restaurantId) {
            return [
                'valid' => false,
                'message' => 'This referral code is not valid for this restaurant.',
            ];
        }

        // 1. Fraud Check: Self referral by User ID
        if ($referralCode->user_id === $refereeUser->id) {
            return [
                'valid' => false,
                'message' => 'You cannot use your own referral code.',
            ];
        }

        // 2. Fraud Check: Email or Phone hash match
        $referrer = User::find($referralCode->user_id);
        if ($referrer) {
            if ($referrer->email_hash && $refereeUser->email_hash && $referrer->email_hash === $refereeUser->email_hash) {
                return [
                    'valid' => false,
                    'message' => 'Self-referral detected using matching user credentials.',
                ];
            }
            if ($referrer->phone_hash && $refereeUser->phone_hash && $referrer->phone_hash === $refereeUser->phone_hash) {
                return [
                    'valid' => false,
                    'message' => 'Self-referral detected using matching phone number.',
                ];
            }
        }

        // 3. Check if referee has already used a referral code for this restaurant
        $alreadyUsed = ReferralUsage::where('referee_id', $refereeUser->id)
            ->where('restaurant_id', $restaurantId)
            ->whereIn('status', ['pending', 'completed'])
            ->exists();

        if ($alreadyUsed) {
            return [
                'valid' => false,
                'message' => 'You have already redeemed a referral discount at this restaurant.',
            ];
        }

        // 4. Fetch settings
        $setting = $this->getReferralSetting($restaurantId);

        if (!$setting->is_active) {
            return [
                'valid' => false,
                'message' => 'Referral program is currently not active for this restaurant.',
            ];
        }

        // 5. Min order subtotal check
        if ($subtotal < (float) $setting->min_order_amount) {
            return [
                'valid' => false,
                'message' => 'Minimum order subtotal of £' . number_format($setting->min_order_amount, 2) . ' is required to use this referral code.',
            ];
        }

        // 6. Calculate discount amount
        $discountAmount = 0.00;
        if ($setting->referee_discount_type === 'percentage') {
            $discountAmount = ($subtotal * (float) $setting->referee_discount_value) / 100;
        } else {
            $discountAmount = (float) $setting->referee_discount_value;
        }

        // Cap discount at subtotal
        if ($discountAmount > $subtotal) {
            $discountAmount = $subtotal;
        }

        return [
            'valid' => true,
            'message' => 'Referral code applied successfully!',
            'discount_amount' => round($discountAmount, 2),
            'referral_code' => $referralCode,
            'setting' => $setting,
        ];
    }

    /**
     * Record referral usage during order creation.
     */
    public function applyReferralToOrder(Order $order, ReferralCode $referralCode, float $refereeDiscountAmount, ReferralSetting $setting)
    {
        $referrerRewardAmount = 0.00;
        if ($setting->referrer_reward_type === 'percentage') {
            $referrerRewardAmount = ($order->total_amount * (float) $setting->referrer_reward_value) / 100;
        } else {
            $referrerRewardAmount = (float) $setting->referrer_reward_value;
        }

        $usage = ReferralUsage::create([
            'referral_code_id' => $referralCode->id,
            'referrer_id' => $referralCode->user_id,
            'referee_id' => $order->user_id,
            'restaurant_id' => $order->restaurant_id,
            'referee_order_id' => $order->id,
            'referee_discount_amount' => round($refereeDiscountAmount, 2),
            'referrer_reward_amount' => round($referrerRewardAmount, 2),
            'status' => 'pending',
        ]);

        $referralCode->increment('usage_count');

        return $usage;
    }

    /**
     * Process referrer reward once the referee order is completed.
     */
    public function processOrderCompletion(Order $order)
    {
        $usage = ReferralUsage::where('referee_order_id', $order->id)
            ->where('status', 'pending')
            ->first();

        if (!$usage) {
            return null;
        }

        // Generate reward coupon for referrer
        $rewardCouponCode = 'REF-' . strtoupper(Str::random(6));

        $coupon = Coupon::create([
            'restaurant_id' => $order->restaurant_id,
            'code' => $rewardCouponCode,
            'title' => 'Referral Reward Discount',
            'description' => 'Reward earned from referring a friend on order #' . $order->id,
            'type' => 'fixed',
            'coupon_type' => 'referral',
            'value' => $usage->referrer_reward_amount,
            'min_order_amount' => 5.00,
            'max_discount' => $usage->referrer_reward_amount,
            'usage_limit' => 1,
            'used_count' => 0,
            'per_user_limit' => 1,
            'starts_at' => now(),
            'expires_at' => now()->addDays(30),
            'status' => true,
        ]);

        $usage->update([
            'status' => 'completed',
            'referrer_reward_coupon_id' => $coupon->id,
            'reward_issued_at' => now(),
        ]);

        Log::info("Referral reward coupon {$rewardCouponCode} issued to referrer ID {$usage->referrer_id} for order #{$order->id}");

        return $usage;
    }

    /**
     * Process referral cancellation if referee order is cancelled.
     */
    public function processOrderCancellation(Order $order)
    {
        $usage = ReferralUsage::where('referee_order_id', $order->id)
            ->where('status', 'pending')
            ->first();

        if ($usage) {
            $usage->update([
                'status' => 'cancelled',
            ]);
        }
    }
}
