<?php

namespace App\Listeners;

use App\Events\AchievementUnlockedEvent;
use App\Events\BadgeUnlockedEvent;
use App\Models\Achievement;
use App\Models\Comment;
use App\Traits\BadgeUnlockTrait;
use App\Models\Badge;
use App\Models\User;
class CommentWrittenListener
{
    use BadgeUnlockTrait;

    /**
     * Handle the Comment written event.
     * @throws \JsonException
     */

    public function handle( $event): void
    {

        $comment = $event->comment;

        // Retrieve the user associated with the comment
        $user_id= Comment::where('body',$comment->body)->value('user_id');

        $user = User::where('id',$user_id)->first();

        // Increment the comments written counter for the user (you should have a 'comments_written' column in your users' table).
        $user->increment('comments_written');

        // Check and unlock relevant achievements.
        $commentsWrittenCount = $user->comments_written;

        if ($commentsWrittenCount === 1) {
            // User has written their first comment, so unlock the "First Comment Written" achievement.
            $this->unlockAchievement($user, 'First Comment Written');
        } elseif ($commentsWrittenCount === 3) {
            // User has written 3 comments, so unlock the "3 Comments Written" achievement.
            $this->unlockAchievement($user, '3 Comments Written');
        } elseif ($commentsWrittenCount === 5) {
            // User has written 5 comments, so unlock the "5 Comments Written" achievement.
            $this->unlockAchievement($user, '5 Comments Written');
        } elseif ($commentsWrittenCount === 10) {
            // User has written 10 comments, so unlock the "10 Comments Written" achievement.
            $this->unlockAchievement($user, '10 Comments Written');
        } elseif ($commentsWrittenCount === 20) {
            // User has written 20 comments, so unlock the "20 Comments Written" achievement.
            $this->unlockAchievement($user, '20 Comments Written');
        }

        // Check if the user has unlocked enough achievements for a new badge.
        $achievementsUnlocked = $user->achievements->count();


        if ($achievementsUnlocked >= 10) {
            $this->unlockBadge($user, 'Master');
        } elseif ($achievementsUnlocked >= 8) {
            $this->unlockBadge($user, 'Advanced');
        } elseif ($achievementsUnlocked >= 4) {
            $this->unlockBadge($user, 'Intermediate');
        } elseif ($achievementsUnlocked >= 0) {
            $this->unlockBadge($user, 'Beginner');
        }

    }

    private function unlockAchievement(User $user, $achievementName): void
    {

        // Check if the user has not already unlocked this achievement to avoid duplicates.
        if (!$user->achievements->pluck('name')->contains($achievementName)) {
            // Get the achievement by name and attach it to the user.
            $achievement = Achievement::where('name', $achievementName)->first();
            if ($achievement) {
                $user->achievements()->attach($achievement->id);
                event(new AchievementUnlockedEvent($achievementName, $user));
            }
        }
    }

    private function unlockBadge(User $user, $badgeName): void
    {

        // Check if the user has not already unlocked this badge to avoid duplicates.
        if (!$user->badges->pluck('name')->contains($badgeName)) {
            // Get the badge by name and attach it to the user.
            $this->unlockTraitBadge($user, $badgeName);

        }
    }}
