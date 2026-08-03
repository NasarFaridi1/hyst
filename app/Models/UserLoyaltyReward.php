<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoyaltyReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'earned_from_order_id',
        'reward_amount',
        'status',
        'expires_at',
        'used_at',
        'used_in_order_id',
    ];

    protected $casts = [
        'reward_amount' => 'float',
        'expires_at'    => 'datetime',
        'used_at'       => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function earnedFromOrder()
    {
        return $this->belongsTo(Order::class, 'earned_from_order_id');
    }

    public function usedInOrder()
    {
        return $this->belongsTo(Order::class, 'used_in_order_id');
    }

    public function isValidForUse(): bool
    {
        return $this->status === 'active' && $this->expires_at && $this->expires_at->isFuture();
    }
}
