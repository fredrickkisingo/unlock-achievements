<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentWrittenListenerTest extends TestCase
{
    /**
     * A basic feature test example.
     * @throws \JsonException
     */
    public function test_example(): void
    {

        // Create a user and comment

        //::factory()
        $user = User::factory()->create();
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);


        // Create an instance of the CommentWrittenListener and pass the CommentWritten event
        $listener = new CommentWrittenListener();

        // Create an instance of the CommentWritten event
                $event = new CommentWritten($comment);

                $listener->handle($event);

        //Check if specific achievements and badges are attached to the user
        $this->assertTrue($user->achievements->contains('name', 'First Comment Written'));
        $this->assertTrue($user->badges->contains('name', 'Beginner'));

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
