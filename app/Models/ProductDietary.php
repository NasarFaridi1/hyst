<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDietary extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'dietary',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}