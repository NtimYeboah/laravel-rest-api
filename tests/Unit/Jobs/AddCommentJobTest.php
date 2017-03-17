<?php

namespace Tests\Unit;

use App\Comment;
use App\Jobs\AddCommentJob;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddCommentJobTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_comment()
    {
        $this->setAuthUser();

        $question = factory(Question::class)->create();
        $comment = factory(Comment::class)->make();

        $this->request->merge($comment->toArray());

        $createdComment = dispatch(new AddCommentJob($this->request, $question));

        $this->assertInstanceOf(Comment::class, $createdComment);
        $this->assertEquals($question->id, $createdComment->commentable_id);
        $this->assertEquals(get_class($question), $createdComment->commentable_type);
        $this->assertNotNull($createdComment->user);
    }
}
