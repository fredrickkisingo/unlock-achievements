<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            ['name' => 'Beginner'],
            ['name' => 'Intermediate'],
            ['name' => 'Advanced'],
            ['name' => 'Master']
        ];

        // Insert the achievement records into the database.
        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
