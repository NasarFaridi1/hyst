<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantCategory extends Model
{
    use HasFactory;

    protected $table = 'restaurant_categories';

    protected $fillable = [
        'name',
        'image',
        'status',
        'display_order'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}