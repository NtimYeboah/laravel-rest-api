<?php

namespace Tests\Feature;

use App\Comment;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_a_comment()
    {
        $question = factory(Question::class)->create();
        $comment = factory(Comment::class)->make();

        $response = $this->json('POST', route('question.answers.store', ['question' => $question]), $comment->toArray());

        $response->assertStatus(201);
    }

    public function test_can_fetch_all_comments()
    {
        $question = factory(Question::class)->create();

        factory(Comment::class, 30)->create([
            'commentable_id' => $question->id,
            'commentable_type' => $question->getMorphClass()
        ]);

        $response = $this->getJson(route('question.comments.index', ['question' => $question]));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'meta' => []
            ]);

        $responseData = json_decode($response->getContent())->data;

        $this->assertCount(30, $responseData);
    }

    public function test_can_fetch_a_single_comment()
    {
        $question = factory(Question::class)->create();

        $comments = factory(Comment::class, 20)->create([
            'commentable_id' => $question->id,
            'commentable_type' => $question->getMorphClass()
        ]);

        $response = $this->getJson(route('question.comments.show', ['question' => $question, 'comment' => $comments->first()]));

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
            ]);
    }
}
