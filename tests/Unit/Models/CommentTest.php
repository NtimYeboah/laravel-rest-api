<?php

namespace Tests\Unit;

use App\Comment;
use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    public function test_morph_relationship_to_question()
    {
        $question = factory(Question::class)->create();

        $comment = factory(Comment::class)->create([
            'commentable_id'   => $question->id,
            'commentable_type' => get_class($question),
        ]);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals($question->id, $comment->commentable_id);
        $this->assertEquals(get_class($question), $comment->commentable_type);
    }

    public function test_comment_belongs_to_user()
    {
        $user = factory(User::class)->create();
        $question = factory(Question::class)->create();

        $comment = factory(Comment::class, 5)->create([
            'user_id'          => $user->id,
            'commentable_id'   => $question->id,
            'commentable_type' => get_class($question),
        ]);

        $this->assertInstanceOf(Comment::class, $comment->first());
        $this->assertInstanceOf(User::class, $comment->first()->user);
        $this->assertEquals(1, count($comment->first()->user));
    }
}
