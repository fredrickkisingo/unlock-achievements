<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AchievementUnlockedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $achievementName;
    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct($achievementName, User $user)
    {
        $this->achievementName = $achievementName;
        $this->user = $user;
    }

}
