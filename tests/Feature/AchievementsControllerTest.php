<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AchievementsControllerTest extends TestCase
{
    /**
     * A Test to test achievements controller index method.
     */
    public function test_example(): void
    {
        // Create a user and attach achievements as needed for testing.

        $user = User::factory()->create();
        // Attach achievements to the user as needed for testing.

        // Make an HTTP GET request to the index method.
        $response = $this->get("users/$user->id/achievements" );

        // Assert the response contains the expected JSON structure and data.
        $response->assertJsonStructure([
            'unlocked_achievements',
            'next_available_achievements',
            'current_badge',
            'next_badge',
            'remaining_to_unlock_next_badge',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
