<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'description',
        'amount',
        'balance',
        'minimum_order_amount',
        'total_usage_limit',
        'total_used',
        'per_user_limit',
        'starts_at',
        'expires_at',
        'status',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Gift card transactions
     */
    public function transactions()
    {
        return $this->hasMany(GiftCardTransaction::class);
    }

    /**
     * Admin who created the gift card
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if gift card is active
     */
    public function isActive()
    {
        if ($this->status !== 'active') {
            return false;
        }

        if ($this->starts_at && now()->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && now()->gt($this->expires_at)) {
            return false;
        }

        return true;
    }
}