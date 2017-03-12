<?php

namespace Tests\Feature;

use Api\Transformers\CommentTransformer;
use App\Comment;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTransformerTest extends TestCase
{
    use DatabaseMigrations;

    private $commentTransformer;

    private $comment;

    private $question;

    public function setUp()
    {
        parent::setUp();

        $this->commentTransformer = new CommentTransformer();

        $this->question = factory(Question::class)->create();
        $this->comment = factory(Comment::class)->create([
            'commentable_id' => $this->question->id,
            'commentable_type' => get_class($this->question)
        ]);
    }

    public function test_can_transform_comment()
    {
        $transformedComment = $this->commentTransformer->transform($this->comment);

        $this->assertInternalType('array', $transformedComment);
        $this->assertArrayHasKeys($transformedComment, 'id', 'body', 'commentable_type');
    }

    public function test_include_user()
    {
        $user = $this->commentTransformer->includeUser($this->comment);

        $this->assertInternalType('object', $user);
    }
}
