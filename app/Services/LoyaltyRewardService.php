<?php

namespace App\Services;

use App\Models\LoyaltyReward;
use App\Models\LoyaltyRewardUsage;
use App\Models\LoyaltyRule;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class LoyaltyRewardService
{
    /**
     * Get the active available loyalty reward for a customer at a given restaurant.
     */
    public function getAvailableReward(?int $userId, int $restaurantId): ?LoyaltyReward
    {
        if (!$userId) {
            return null;
        }

        return LoyaltyReward::where('user_id', $userId)
            ->where('restaurant_id', $restaurantId)
            ->available()
            ->orderBy('expires_at', 'asc')
            ->first();
    }

    /**
     * Process reward redemption on checkout placement.
     *
     * @return array{reward: ?LoyaltyReward, discount: float}
     */
    public function processRedemption(Order $order, ?int $rewardId, float $subtotal): array
    {
        if (!$order->user_id || !$rewardId || $subtotal <= 0) {
            return ['reward' => null, 'discount' => 0.00];
        }

        $reward = LoyaltyReward::where('id', $rewardId)
            ->where('user_id', $order->user_id)
            ->where('restaurant_id', $order->restaurant_id)
            ->available()
            ->first();

        if (!$reward) {
            return ['reward' => null, 'discount' => 0.00];
        }

        $discount = $reward->calculateDiscount($subtotal);

        if ($discount <= 0) {
            return ['reward' => null, 'discount' => 0.00];
        }

        // Record usage
        LoyaltyRewardUsage::create([
            'loyalty_reward_id' => $reward->id,
            'order_id'          => $order->id,
            'discount_amount'   => $discount,
            'created_at'        => now(),
        ]);

        // Update reward usage count and status
        $newUsageCount = $reward->usage_count + 1;
        $status = ($newUsageCount >= $reward->max_usage) ? 'used' : 'available';

        $reward->update([
            'usage_count' => $newUsageCount,
            'status'      => $status,
        ]);

        Log::info('LOYALTY REWARD REDEEMED', [
            'reward_id'  => $reward->id,
            'order_id'   => $order->id,
            'discount'   => $discount,
            'new_status' => $status,
        ]);

        return ['reward' => $reward, 'discount' => $discount];
    }

    /**
     * Evaluate restaurant loyalty rules on order placement and issue a new reward if eligible.
     * Earned reward becomes available for the customer's NEXT order.
     */
    public function evaluateAndIssueReward(Order $order, float $qualifyingAmount): ?LoyaltyReward
    {
        if (!$order->user_id) {
            return null;
        }

        $activeRule = LoyaltyRule::where('restaurant_id', $order->restaurant_id)
            ->where('is_active', 1)
            ->where('minimum_order_amount', '<=', $qualifyingAmount)
            ->orderBy('minimum_order_amount', 'desc')
            ->first();

        if (!$activeRule) {
            return null;
        }

        $expiresAt = $activeRule->expiry_days > 0 
            ? now()->addDays($activeRule->expiry_days) 
            : null;

        $reward = LoyaltyReward::create([
            'restaurant_id'   => $order->restaurant_id,
            'user_id'         => $order->user_id,
            'order_id'        => $order->id,
            'loyalty_rule_id' => $activeRule->id,
            'reward_type'     => $activeRule->reward_type,
            'reward_value'    => $activeRule->reward_value,
            'status'          => 'available',
            'usage_count'     => 0,
            'max_usage'       => $activeRule->max_usage,
            'expires_at'      => $expiresAt,
        ]);

        Log::info('LOYALTY REWARD AUTOMATICALLY ISSUED FOR NEXT ORDER', [
            'reward_id'         => $reward->id,
            'user_id'           => $order->user_id,
            'restaurant_id'     => $order->restaurant_id,
            'earned_from_order' => $order->id,
            'reward_type'       => $activeRule->reward_type,
            'reward_value'      => $activeRule->reward_value,
            'expires_at'        => $expiresAt,
        ]);

        return $reward;
    }
}
