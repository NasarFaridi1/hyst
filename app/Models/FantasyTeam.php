<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FantasyTeam extends Model
{
    use HasFactory;

    protected $table = 'fantasy_teams';

    protected $fillable = [
        'user_id',
        'name',
        'formation',
        'captain_player_copy_id',
        'total_strength',
        'is_active',
    ];

    protected $casts = [
        'total_strength' => 'integer',
        'is_active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function captain()
    {
        return $this->belongsTo(PlayerCopy::class, 'captain_player_copy_id');
    }

    public function selections()
    {
        return $this->hasMany(TeamPlayerSelection::class, 'team_id');
    }
}
