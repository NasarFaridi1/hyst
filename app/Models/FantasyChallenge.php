<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FantasyChallenge extends Model
{
    use HasFactory;

    protected $table = 'fantasy_challenges';

    protected $fillable = [
        'challenger_id',
        'defender_id',
        'challenger_team_id',
        'defender_team_id',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function challenger()
    {
        return $this->belongsTo(User::class, 'challenger_id');
    }

    public function defender()
    {
        return $this->belongsTo(User::class, 'defender_id');
    }

    public function challengerTeam()
    {
        return $this->belongsTo(FantasyTeam::class, 'challenger_team_id');
    }

    public function defenderTeam()
    {
        return $this->belongsTo(FantasyTeam::class, 'defender_team_id');
    }

    public function game()
    {
        return $this->hasOne(FantasyGame::class, 'challenge_id');
    }
}
