<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemAddon extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'addon_id',
        'category_name',
        'addon_name',
        'price',
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function addon()
    {
        return $this->belongsTo(ProductAddon::class, 'addon_id');
    }
}