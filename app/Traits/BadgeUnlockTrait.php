<?php
namespace App\Traits;

use App\Models\Badge;
use App\Events\BadgeUnlockedEvent;
use Illuminate\Database\Eloquent\Model;

trait BadgeUnlockTrait
{
public function unlockTraitBadge(Model $user, string $badgeName): void
{


    $badge = Badge::where('name', $badgeName)->first();

    if ($badge && !$user->badges->pluck('name')->contains($badgeName)) {
        $user->badges()->attach($badge->id);
        event(new BadgeUnlockedEvent($badgeName, $user));
    }
}
}
