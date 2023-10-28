<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }


    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class,'user_achievements');
    }



    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'user_badges');

    }

    public function currentBadge(): string
    {

        $achievementsCount = $this->achievements()->count();

        if ($achievementsCount >= 10) {
            return 'Master';
        }

        if ($achievementsCount >= 8) {
            return 'Advanced';
        }

        if ($achievementsCount >= 4) {
            return 'Intermediate';
        }

        return 'Beginner';
    }
    public function nextBadge(): string
    {
        $achievementsCount = $this->achievements()->count();

        if ($achievementsCount >= 10) {
            return 'You have already earned the highest badge - Master';
        } elseif ($achievementsCount >= 8) {
            return 'Next badge: Master (Complete 10 achievements)';
        } elseif ($achievementsCount >= 4) {
            $additionalAchievementsRequired = 10 - $achievementsCount;
            return "Next badge: Advanced (Complete 10 achievements, $additionalAchievementsRequired more to go)";
        } else {
            $additionalAchievementsRequired = 4 - $achievementsCount;
            return "Next badge: Intermediate (Complete 4 achievements, $additionalAchievementsRequired more to go)";
        }
    }

    public function remainingAchievementsToUnlockNextBadge(): ?int
    {
        $achievementsCount = $this->achievements()->count();

        if ($achievementsCount >= 10) {
            return 0; // User has already earned the highest badge.
        } elseif ($achievementsCount >= 8) {
            return 10 - $achievementsCount; // Additional achievements required for the "Master" badge.
        } elseif ($achievementsCount >= 4) {
            return 10 - $achievementsCount; // Additional achievements required for the "Advanced" badge.
        } else {
            return 4 - $achievementsCount; // Additional achievements required for the "Intermediate" badge.
        }
    }
}

