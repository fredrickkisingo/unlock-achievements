<?php

namespace Tests\Unit;

use App\Events\CommentWritten;
use App\Listeners\CommentWrittenListener;
use App\Models\Comment;
use Tests\TestCase;

class CommentWrittenTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        // Mock a comment or create one in your database

        $comment =    Comment::factory()->create();

        // Create an instance of the listener
        $listener = new CommentWrittenListener();

//        // Trigger the CommentWritten event
//        event(new CommentWritten($comment));

        $this->assertTrue(true);
    }
}
