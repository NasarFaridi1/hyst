<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantBanner extends Model
{
    use HasFactory;

    protected $table = 'restaurant_banners';

    protected $fillable = [
        'restaurant_id',
        'image',
        'mobile_img',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Banner belongs to a restaurant.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
}