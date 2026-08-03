<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyRewardUsage extends Model
{
    use HasFactory;

    protected $table = 'loyalty_reward_usages';

    public $timestamps = false;

    protected $fillable = [
        'loyalty_reward_id',
        'order_id',
        'discount_amount',
        'created_at',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function loyaltyReward()
    {
        return $this->belongsTo(LoyaltyReward::class, 'loyalty_reward_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
