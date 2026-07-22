<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeVisitor extends Model
{
    protected $connection = 'logs_db';

    protected $table = 'home_visitors';

    protected $fillable = [
        'user_id',
        'ip_address',
        'city',
        'state',
        'country',
        'latitude',
        'longitude',
        'user_agent'
    ];
}