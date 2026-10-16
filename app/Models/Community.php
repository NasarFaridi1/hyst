<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Community extends Model
{
    use HasFactory;

    protected $table = 'communities';

    protected $fillable = [
        'creator_user_id',
        'name',
        'invite_code',
        'description',
        'avatar',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }

    public function members()
    {
        return $this->hasMany(CommunityMember::class, 'community_id');
    }

    public function posts()
    {
        return $this->hasMany(CommunityPost::class, 'community_id')->latest();
    }

    /**
     * Retrieve or automatically initialize a user's default Foodie Circle
     */
    public static function getOrCreateForUser(User $user): ?self
    {
        try {
            $circle = self::where('creator_user_id', $user->id)->first();
            if (!$circle) {
                $rawName = $user->name ? explode(' ', trim($user->name))[0] : 'Foodie';
                $circle = self::create([
                    'creator_user_id' => $user->id,
                    'name'            => "{$rawName}'s Foodie Circle",
                    'invite_code'     => 'HYST-' . strtoupper(Str::random(6)),
                    'description'     => "Welcome to my private Foodie Circle on HYST! Join to discover my favorite dishes and local restaurant recommendations.",
                ]);

                // Register creator as a member
                CommunityMember::firstOrCreate([
                    'community_id' => $circle->id,
                    'user_id'      => $user->id,
                ], [
                    'role'         => 'creator',
                    'joined_at'    => now(),
                ]);
            }
            return $circle;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
