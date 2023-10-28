<?php

namespace Tests\Feature;

use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Listeners\CommentWrittenListener;
use App\Listeners\LessonWatchedListener;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonWatchedListenerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // Create a user and comment

        //::factory()
        $user = User::factory()->create();
        $lesson = Lesson::where('id',1)->first();


        // Create an instance of the LessonWatchedListener and pass the LessonWatched event
        $lesson_listener = new LessonWatchedListener();

        // Create an instance of the CommentWritten event
        $event = new LessonWatched($lesson,$user);

        $lesson_listener->handle($event);



        //Check if specific achievements and badges are attached to the user
        $this->assertTrue($user->achievements()->contains('name', 'First Lesson Watched'));
        $this->assertTrue($user->badges->contains('name', 'Beginner'));
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
