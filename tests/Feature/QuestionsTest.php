<?php

namespace Tests\Feature;

use App\Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_questions()
    {
        $question = factory(Question::class)->make();

        $response = $this->json('POST', '/api/v1/questions', $question->toArray());

        $response->assertStatus(201)
            ->assertExactJson([
                'message' => 'Resource created',
                'code'    => 201,
            ]);
    }

    public function test_can_get_all_questions()
    {
        factory(Question::class, 120)->create();

        $response = $this->getJson('/api/v1/questions');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'meta' => []
            ]);
    }

    public function test_can_get_a_single_question()
    {
        $questions = factory(Question::class, 10)->create();

        $response = $this->getJson("/api/v1/questions/{$questions->first()->id}");

        $response->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }

    public function test_response_when_validation_fails()
    {
        $question = factory(Question::class)->make(['title' => 'This is a title', 'body' => null]);

        $response = $this->json('POST', '/api/v1/questions', $question->toArray());

        $response->assertStatus(422);
    }

    public function test_response_when_model_is_not_found()
    {
        $response = $this->getJson('/api/v1/questions/x');

        $response->assertStatus(404);
    }
}
