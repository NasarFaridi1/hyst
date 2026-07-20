<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderOffer extends Model
{
    use HasFactory;

    protected $table = 'order_offers';

    protected $fillable = [
        'title',
        'description',
        'min_order_value',
        'value',
        'value_type',
        'start_date',
        'end_date',
        'status',
        'restaurant_id'
    ];

    protected $casts = [
        'min_order_value' => 'decimal:2',
        'value' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Check if offer is currently active
     */
    public function isActive(): bool
    {
        return $this->status === 'active'
            && now()->between($this->start_date, $this->end_date);
    }

    /**
     * Get restaurant
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $orderAmount): float
    {
        if ($orderAmount < $this->min_order_value) {
            return 0;
        }

        if ($this->value_type === 'percentage') {
            return ($orderAmount * $this->value) / 100;
        }

        return min($this->value, $orderAmount);
    }

    /**
     * Scope active offers
     */
    public function scopeActive($query)
    {
        return $query
            ->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }
}