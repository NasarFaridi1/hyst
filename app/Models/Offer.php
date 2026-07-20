<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [

        'restaurant_id',
        'title',
        'description',
        'type',
        'value',
        'value_type',
        'image',
        'is_active',
        'is_featured',
        'start_date',
        'end_date'
    ];

    public function restaurant()
    {
        return $this->belongsTo(
            Restaurant::class
        );
    }
    public function products()
{
    return $this->belongsToMany(
        Product::class,
        'offer_products'
    );
}

}