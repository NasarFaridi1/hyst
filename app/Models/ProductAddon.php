<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAddon extends Model
{
    use HasFactory;

    protected $table = 'product_addons';

    protected $fillable = [
        'product_id',
        'category_name',
        'addon_name',
        'price',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}