<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerCatalogue extends Model
{
    use HasFactory;

    protected $table = 'player_catalogue';

    protected $fillable = [
        'name',
        'display_name',
        'position',
        'sub_position',
        'club_name',
        'nationality',
        'avatar_url',
        'rarity',
        'stat_attack',
        'stat_defence',
        'stat_midfield',
        'stat_goalkeeping',
        'overall_rating',
        'is_active',
    ];

    protected $casts = [
        'stat_attack' => 'integer',
        'stat_defence' => 'integer',
        'stat_midfield' => 'integer',
        'stat_goalkeeping' => 'integer',
        'overall_rating' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): string
    {
        if (!empty($this->avatar_url)) {
            if (str_starts_with($this->avatar_url, 'http://') || str_starts_with($this->avatar_url, 'https://')) {
                return $this->avatar_url;
            }
            return asset($this->avatar_url);
        }

        $slug = \Illuminate\Support\Str::slug($this->name);
        if (file_exists(public_path("images/players/{$slug}.png"))) {
            return asset("images/players/{$slug}.png");
        }
        if (file_exists(public_path("images/players/{$slug}.jpg"))) {
            return asset("images/players/{$slug}.jpg");
        }
        if (file_exists(public_path("images/players/{$this->id}.png"))) {
            return asset("images/players/{$this->id}.png");
        }

        $name = urlencode($this->display_name ?: $this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=0A192F&color=FFFFFF&size=250&bold=true&format=svg";
    }

    public function copies()
    {
        return $this->hasMany(PlayerCopy::class, 'catalogue_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
