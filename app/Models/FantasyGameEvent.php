<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FantasyGameEvent extends Model
{
    use HasFactory;

    protected $table = 'fantasy_game_events';
    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'minute',
        'event_type',
        'actor_name',
        'description',
        'created_at',
    ];

    protected $casts = [
        'minute' => 'integer',
        'created_at' => 'datetime',
    ];

    public function game()
    {
        return $this->belongsTo(FantasyGame::class, 'game_id');
    }
}
