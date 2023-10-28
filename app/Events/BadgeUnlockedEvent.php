<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BadgeUnlockedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public string $badgeName;
    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct($badgeName, User $user)
    {
        $this->badgeName = $badgeName;
        $this->user = $user;
    }


}
