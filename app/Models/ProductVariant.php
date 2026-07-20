<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'price',
        'is_default',
        'status',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'status' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}