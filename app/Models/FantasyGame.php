<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FantasyGame extends Model
{
    use HasFactory;

    protected $table = 'fantasy_games';
    public $timestamps = false;

    protected $fillable = [
        'challenge_id',
        'challenger_id',
        'defender_id',
        'challenger_team_id',
        'defender_team_id',
        'challenger_score',
        'defender_score',
        'winner_id',
        'match_summary',
        'played_at',
    ];

    protected $casts = [
        'challenger_score' => 'integer',
        'defender_score' => 'integer',
        'match_summary' => 'array',
        'played_at' => 'datetime',
    ];

    public function challenge()
    {
        return $this->belongsTo(FantasyChallenge::class, 'challenge_id');
    }

    public function challenger()
    {
        return $this->belongsTo(User::class, 'challenger_id');
    }

    public function defender()
    {
        return $this->belongsTo(User::class, 'defender_id');
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function challengerTeam()
    {
        return $this->belongsTo(FantasyTeam::class, 'challenger_team_id');
    }

    public function defenderTeam()
    {
        return $this->belongsTo(FantasyTeam::class, 'defender_team_id');
    }

    public function events()
    {
        return $this->hasMany(FantasyGameEvent::class, 'game_id')->orderBy('minute', 'asc');
    }
}
