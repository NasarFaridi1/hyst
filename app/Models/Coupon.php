<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'code',
        'title',
        'description',
        'type',
        'value',
        'min_order_amount',
        'max_discount',
        'usage_limit',
        'used_count',
        'per_user_limit',
        'starts_at',
        'expires_at',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => 'boolean',
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount' => 'decimal:2',
    ];

    /**
     * Restaurant that owns the coupon
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Coupon usages
     */
    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Orders where this coupon was used
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query
            ->where('status', 1)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                ->orWhere('starts_at', '<=', Carbon::now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')
                ->orWhere('expires_at', '>=', Carbon::now());
            });
    }
}