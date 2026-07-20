<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTermsCondition extends Model
{
    protected $table = 'restaurant_terms_conditions';

    protected $fillable = [
        'restaurant_id',
        'content',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}