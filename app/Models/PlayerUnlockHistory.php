<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerUnlockHistory extends Model
{
    use HasFactory;

    protected $table = 'player_unlock_history';
    public $timestamps = false;

    protected $fillable = [
        'entitlement_id',
        'user_id',
        'player_copy_id',
        'catalogue_id',
        'selected_at',
    ];

    protected $casts = [
        'selected_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function playerCopy()
    {
        return $this->belongsTo(PlayerCopy::class, 'player_copy_id');
    }

    public function catalogue()
    {
        return $this->belongsTo(PlayerCatalogue::class, 'catalogue_id');
    }
}
