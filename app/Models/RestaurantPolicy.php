<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantPolicy extends Model
{
    protected $table = 'restaurant_policy';

    protected $fillable = [
        'restaurant_id',
        'content',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}