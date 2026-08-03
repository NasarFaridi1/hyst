<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyRule extends Model
{
    use HasFactory;

    protected $table = 'loyalty_rules';

    protected $fillable = [
        'restaurant_id',
        'name',
        'minimum_order_amount',
        'reward_type',
        'reward_value',
        'expiry_days',
        'max_usage',
        'is_active',
    ];

    protected $casts = [
        'minimum_order_amount' => 'decimal:2',
        'reward_value' => 'decimal:2',
        'expiry_days' => 'integer',
        'max_usage' => 'integer',
        'is_active' => 'integer',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    public function rewards()
    {
        return $this->hasMany(LoyaltyReward::class, 'loyalty_rule_id');
    }
}
