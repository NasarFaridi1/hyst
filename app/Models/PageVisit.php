<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PageVisit extends Model
{
    protected $connection = 'logs_db';

    protected $table = 'page_visits';

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'restaurant_name',
        'order_id',
        'product_id',
        'page_name',
        'page_url',
        'ip_address',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'browser',
        'platform',
        'user_agent',
        'session_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}