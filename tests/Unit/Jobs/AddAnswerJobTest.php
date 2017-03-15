<?php

namespace Tests\Feature;

use App\Jobs\AddAnswerJob;
use App\Question;
use App\Answer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddAnswerJobTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_answer()
    {
        $this->setAuthUser();

        $question = factory(Question::class)->create();

        $answer = factory(Answer::class)->make(['question_id' => null])->toArray();
        $this->request->merge($answer);

        $createdAnswer = dispatch(new AddAnswerJob($this->request, $question));

        $this->assertInstanceOf(Answer::class, $createdAnswer);
        $this->assertNotNull($createdAnswer->question);
        $this->assertEquals($createdAnswer->question->id, $question->id);
        $this->assertNotNull($createdAnswer->user);
    }

    public function test_can_update_an_answer()
    {
        $this->setAuthUser();

        $answer = factory(Answer::class)->create();

        $this->request->merge(
            factory(Answer::class)->make(['body' => 'An updated answer body'])->toArray()
        );

        $updateAnswer = dispatch(new AddAnswerJob($this->request, null, $answer));

        $this->assertInstanceOf(Answer::class, $updateAnswer);
        $this->assertEquals('An updated answer body', $updateAnswer->body);
    }
}
