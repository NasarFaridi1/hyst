<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'description',
        'image',
        'price',
        'currency',
        'status',
        'image_3d',
        'allergy',
        'dietary',
        'product_type'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function vendor()
    {
        return $this->belongsTo(User::class,'vendor_id');
    }
    public function offers()
    {
        return $this->belongsToMany(
            Offer::class,
            'offer_products'
        );
    }
        public function ambassador()
    {
        return $this->belongsTo(User::class,'ambassador_id');
    }
     public function allergies()
    {
        return $this->hasMany(ProductAllergy::class);
    }

    public function dietaries()
    {
        return $this->hasMany(ProductDietary::class);
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function addons()
    {
        return $this->hasMany(ProductAddon::class);
    }
}