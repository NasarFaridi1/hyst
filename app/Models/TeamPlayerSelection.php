<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamPlayerSelection extends Model
{
    use HasFactory;

    protected $table = 'team_player_selections';
    public $timestamps = false;

    protected $fillable = [
        'team_id',
        'player_copy_id',
        'pitch_position',
        'is_shared',
        'created_at',
    ];

    protected $casts = [
        'is_shared' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(FantasyTeam::class, 'team_id');
    }

    public function playerCopy()
    {
        return $this->belongsTo(PlayerCopy::class, 'player_copy_id');
    }
}
