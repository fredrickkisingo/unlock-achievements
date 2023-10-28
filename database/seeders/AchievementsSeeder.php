<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $achievements = [
            ['name' => 'First Lesson Watched', 'criteria' => 'lessons_watched_count:1'],
            ['name' => '5 Lessons Watched', 'criteria' => 'lessons_watched_count:5'],
            ['name' => '10 Lessons Watched', 'criteria' => 'lessons_watched_count:10'],
            ['name' => '25 Lessons Watched', 'criteria' => 'lessons_watched_count:25'],
            ['name' => '50 Lessons Watched', 'criteria' => 'lessons_watched_count:50'],
            ['name' => 'First Comment Written', 'criteria' => 'comments_written_count:1'],
            ['name' => '3 Comments Written', 'criteria' => 'comments_written_count:3'],
            ['name' => '5 Comments Written', 'criteria' => 'comments_written_count:5'],
            ['name' => '10 Comments Written', 'criteria' => 'comments_written_count:10'],
            ['name' => '20 Comments Written', 'criteria' => 'comments_written_count:20'],
        ];

        // Insert the achievement records into the database.
        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
