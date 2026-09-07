<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralUsage extends Model
{
    use HasFactory;

    protected $table = 'referral_usages';

    protected $fillable = [
        'referral_code_id',
        'referrer_id',
        'referee_id',
        'restaurant_id',
        'referee_order_id',
        'referrer_reward_coupon_id',
        'referee_discount_amount',
        'referrer_reward_amount',
        'status',
        'reward_issued_at',
    ];

    protected $casts = [
        'referee_discount_amount' => 'decimal:2',
        'referrer_reward_amount' => 'decimal:2',
        'reward_issued_at' => 'datetime',
    ];

    public function referralCode()
    {
        return $this->belongsTo(ReferralCode::class, 'referral_code_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'referee_order_id');
    }

    public function referrerRewardCoupon()
    {
        return $this->belongsTo(Coupon::class, 'referrer_reward_coupon_id');
    }
}
