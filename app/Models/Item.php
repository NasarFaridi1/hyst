<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [

        'restaurant_id',
        'name',
        'unit',
        'price',
        'quantity',
        'description',
        'image',
        'status'

    ];
}