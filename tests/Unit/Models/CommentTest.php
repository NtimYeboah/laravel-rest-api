<?php

namespace Tests\Unit;

use App\Comment;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    public function test_morph_relationship_to_question()
    {
        $question = factory(Question::class)->create();

        $comment = factory(Comment::class)->create([
            'commentable_id' => $question->id,
            'commentable_type' => get_class($question)
        ]);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($question->id, $comment->commentable_id);
        $this->assertEquals(get_class($question), $comment->commentable_type);
    }
}
