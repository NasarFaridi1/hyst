<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerTransfer extends Model
{
    use HasFactory;

    protected $table = 'player_transfers';
    public $timestamps = false;

    protected $fillable = [
        'player_copy_id',
        'sender_id',
        'recipient_id',
        'status',
        'message',
        'created_at',
        'responded_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'responded_at' => 'datetime',
    ];

    public function playerCopy()
    {
        return $this->belongsTo(PlayerCopy::class, 'player_copy_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
