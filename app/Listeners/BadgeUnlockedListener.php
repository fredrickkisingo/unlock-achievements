<?php

namespace App\Listeners;


use App\Models\Badge;
class BadgeUnlockedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //fetch badge by name
        $badge= Badge::where('name',$event->badgeName)->first();

        //attach badge with user
        if(!$badge) {
            return;
        }
        $event->user->badges()->syncWithoutDetaching([$badge->id]);
    }
}
