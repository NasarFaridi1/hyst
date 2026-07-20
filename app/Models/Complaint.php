<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'order_id',
        'product_id',
        'subject',
        'complaint',
        'status',
        'restaurant_reply',
        'replied_at',
        'category'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function messages()
    {
        return $this->hasMany(ComplaintMessage::class)
                    ->orderBy('created_at', 'asc');
    }
}