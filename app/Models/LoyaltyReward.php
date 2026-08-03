<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyReward extends Model
{
    use HasFactory;

    protected $table = 'loyalty_rewards';

    protected $fillable = [
        'restaurant_id',
        'user_id',
        'order_id',
        'loyalty_rule_id',
        'reward_type',
        'reward_value',
        'status',
        'usage_count',
        'max_usage',
        'expires_at',
    ];

    protected $casts = [
        'reward_value' => 'decimal:2',
        'usage_count' => 'integer',
        'max_usage' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The order from which this reward was earned.
     */
    public function earnedFromOrder()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function loyaltyRule()
    {
        return $this->belongsTo(LoyaltyRule::class, 'loyalty_rule_id');
    }

    public function usages()
    {
        return $this->hasMany(LoyaltyRewardUsage::class, 'loyalty_reward_id');
    }

    /**
     * Scope for available rewards.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available')
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            })
            ->whereColumn('usage_count', '<', 'max_usage');
    }

    /**
     * Calculate discount amount for a given order subtotal.
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal <= 0) {
            return 0.00;
        }

        if ($this->reward_type === 'percentage') {
            $discount = ($subtotal * (float) $this->reward_value) / 100.0;
        } else {
            $discount = (float) $this->reward_value;
        }

        return round(min($discount, $subtotal), 2);
    }
}
