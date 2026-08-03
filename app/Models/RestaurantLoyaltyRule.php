<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantLoyaltyRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'min_order_amount',
        'reward_amount',
        'expiry_days',
        'max_uses_per_user',
        'is_active',
    ];

    protected $casts = [
        'min_order_amount'  => 'float',
        'reward_amount'     => 'float',
        'expiry_days'       => 'integer',
        'max_uses_per_user' => 'integer',
        'is_active'         => 'boolean',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
