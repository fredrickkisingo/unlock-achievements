<?php

namespace App\Listeners;

use App\Events\AchievementUnlockedEvent;
use App\Events\BadgeUnlockedEvent;
use App\Traits\BadgeUnlockTrait;
use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LessonWatched;
use App\Models\User;
class LessonWatchedListener
{

    use BadgeUnlockTrait;

    /**
     * Handle the Lesson watched event.
     */
    public function handle(LessonWatched $event): void
    {
        $user = $event->user;
        $lesson = $event->lesson;


        // Increment the lessons watched counter for the user (you should have a 'lessons_watched' column in your users table).
        $user->increment('lessons_watched');

        // Attach the lesson to user.
        $user->lessons()->attach($lesson->id,['watched' => true]);
        // Check and unlock relevant achievements.
        if ($user->lessons_watched === 1) {
            $this->unlockAchievement($user, 'First Lesson Watched');
        } elseif ($user->lessons_watched === 5) {
            $this->unlockAchievement($user, '5 Lessons Watched');
        } elseif ($user->lessons_watched === 10) {
            $this->unlockAchievement($user, '10 Lessons Watched');
        } elseif ($user->lessons_watched === 25) {
            // User has watched 25 lessons, so unlock the "25 Lessons Watched" achievement.
            $this->unlockAchievement($user, '25 Lessons Watched');
        } elseif ($user->lessons_watched === 50) {
            // User has watched 50 lessons, so unlock the "50 Lessons Watched" achievement.
            $this->unlockAchievement($user, '50 Lessons Watched');
        }

        // Check if the user has unlocked enough achievements for a new badge.
        $lessonsWatchedAchievements = $user->achievements->count();

        if ($lessonsWatchedAchievements >= 10) {
            $this->unlockLessonBadge($user, 'Master');
        } elseif ($lessonsWatchedAchievements >= 8) {
            $this->unlockLessonBadge($user, 'Advanced');
        } elseif ($lessonsWatchedAchievements >= 4) {
            $this->unlockLessonBadge($user, 'Intermediate');
        } elseif ($lessonsWatchedAchievements >= 0) {
            $this->unlockLessonBadge($user, 'Beginner');
        }
    }

    private function unlockAchievement(User $user, $achievementName): void
    {
        // Check if user hasn't unlocked achievement.
        if (!$user->achievements->pluck('name')->contains($achievementName)) {
            // Get the achievement by name and attach it to the user.
            $achievement = Achievement::where('name', $achievementName)->first();
            if ($achievement) {
                $user->achievements()->attach($achievement->id);
                event(new AchievementUnlockedEvent($achievementName, $user));
            }
        }
    }

    private function unlockLessonBadge(User $user, $badgeName): void
    {
        // Check if the user has not already unlocked this badge to avoid duplicates.
        if (!$user->badges->pluck('name')->contains($badgeName)) {
            // Get the badge by name and attach it to the user.
            $this->unlockTraitBadge($user, $badgeName);

        }
    }
}
