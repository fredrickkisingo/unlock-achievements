<?php

namespace App\Listeners;

use App\Models\Achievement;
class AchievementUnlockedListener
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
        //retrieve achievement from achievement model
        $achievement= Achievement::where('name',$event->achievementName)->first();

        if($achievement){
            $event->user->achievements()->syncWithoutDetaching([$achievement->id]);;
        }
    }
}
