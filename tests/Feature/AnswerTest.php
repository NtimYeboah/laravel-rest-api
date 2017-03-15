<?php

namespace Tests\Feature;

use App\Answer;
use App\Question;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnswerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_answer()
    {
        $question = factory(Question::class)->create();

        $answer = factory(Answer::class)->make(['question_id' => null])->toArray();

        $response = $this->json('POST', "/api/v1/question/{$question->id}/answers", $answer);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Resource created',
                'code' => 201
            ]);
    }

    public function test_can_fetch_all_answers_in_a_particular_question()
    {
        $question = factory(Question::class)->create();

        factory(Answer::class, 10)->create(['question_id' => $question->id]);

        $response = $this->json('GET', "/api/v1/question/{$question->id}/answers");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'meta' => []
            ]);

        $responseData = json_decode($response->getContent())->data;

        $this->assertCount(10, $responseData);
    }

    public function test_can_fetch_a_single_answer()
    {
        $question = factory(Question::class)->create();

        $answers = factory(Answer::class, 10)->create(['question_id' => $question->id]);

        $response = $this->getJson("/api/v1/question/{$question->id}/answers/{$answers->first()->id}");

        $response->assertStatus(200);
    }

    public function test_can_fetch_paginated_answers()
    {
        $question = factory(Question::class)->create();

        factory(Answer::class, 60)->create(['question_id' => $question->id]);

        $response = $this->json('GET', "/api/v1/question/{$question->id}/answers");

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
                'meta' => []
            ]);

        $responseData = json_decode($response->getContent())->data;
        
        $this->assertCount(30, $responseData);
    }
}
