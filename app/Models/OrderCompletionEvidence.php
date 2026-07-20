<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderCompletionEvidence extends Model
{
    use HasFactory;

    protected $table = 'order_completion_evidence';

    protected $fillable = [
        'order_id',
        'uploader_type',
        'photo',
        'description',
    ];

    /**
     * Uploader Types
     */
    const RESTAURANT = 'restaurant';
    const CUSTOMER = 'customer';

    /**
     * Order Relationship
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Scope: Restaurant uploads
     */
    public function scopeRestaurant($query)
    {
        return $query->where('uploader_type', self::RESTAURANT);
    }

    /**
     * Scope: Customer uploads
     */
    public function scopeCustomer($query)
    {
        return $query->where('uploader_type', self::CUSTOMER);
    }
}