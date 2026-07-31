<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'user_id',
        'name',
        'email',
        'phone',
        'order_id',
        'subject',
        'message',
        'status',
        'priority',
    ];

    protected $casts = [
        'email' => 'encrypted',
        'phone' => 'encrypted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id')->latest();
    }
}
