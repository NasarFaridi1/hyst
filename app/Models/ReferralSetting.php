<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralSetting extends Model
{
    use HasFactory;

    protected $table = 'referral_settings';

    protected $fillable = [
        'restaurant_id',
        'referee_discount_type',
        'referee_discount_value',
        'min_order_amount',
        'referrer_reward_type',
        'referrer_reward_value',
        'is_active',
    ];

    protected $casts = [
        'referee_discount_value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'referrer_reward_value' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
