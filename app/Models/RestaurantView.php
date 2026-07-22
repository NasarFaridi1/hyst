<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantView extends Model
{
    protected $connection = 'logs_db';

    protected $table = 'restaurant_views';

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'restaurant_name',
        'ip_address',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'user_agent'
    ];
}