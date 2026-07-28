<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantDeliveryCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'from_distance',
        'to_distance',
        'delivery_charge',
        'free_delivery_min_order'
    ];

    protected $casts = [
        'from_distance'   => 'decimal:2',
        'to_distance'     => 'decimal:2',
        'delivery_charge' => 'decimal:2',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}