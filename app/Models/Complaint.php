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

'category',

'resolved_by',

'resolved_at',

'resolution_note'

];

    protected $casts = [
        'replied_at' => 'datetime',
        'resolved_at'=>'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function resolver()
{
    return $this->belongsTo(User::class,'resolved_by');
}
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

    public function getStatusBadgeAttribute()
{
    return match($this->status){

        'open'=>'warning',

        'restaurant_replied'=>'info',

        'admin_replied'=>'primary',

        'waiting_customer'=>'secondary',

        'waiting_restaurant'=>'secondary',

        'resolved'=>'success',

        'closed'=>'dark',

        'rejected'=>'danger',

        default=>'secondary'

    };
}
}