<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        // Get all achievements grouped by their category.


        $groupedAchievements = Achievement::all()->groupBy('criteria');

        // Initialize arrays to store the next available achievements and the unlocked achievements.
        $nextAvailableAchievements = [];
        $unlockedAchievements = $user->achievements->pluck('name')->toArray();

        // Iterate through each group of achievements.
        foreach ($groupedAchievements as $category => $achievements) {
            // Find the first achievement in the group that the user has not unlocked.
            $nextAchievement = $achievements->first(function ($achievement) use ($unlockedAchievements) {
                return !in_array($achievement->name, $unlockedAchievements, true);
            });

            // If a next achievement is found, add it to the list of next available achievements.
            if ($nextAchievement) {
                $nextAvailableAchievements[] = $nextAchievement->name;
            }
        }

        // Get the current badge, next badge, and calculate the remaining achievements needed.
        $currentBadge = $user->currentBadge();
        $nextBadge = $user->nextBadge();
        $remainingToUnlockNextBadge = $user->remainingAchievementsToUnlockNextBadge();

        return [
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ];
    }
}
