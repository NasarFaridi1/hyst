<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'restaurant_id',
        'user_id',
        'order_id',
        'discount_amount',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Coupon
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Restaurant
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}