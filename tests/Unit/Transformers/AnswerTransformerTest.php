<?php

namespace Tests\Feature;

use Api\Transformers\AnswerTransformer;
use App\Answer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnswerTransformerTest extends TestCase
{
    use DatabaseMigrations;

    private $answerTransformer;

    private $answer;

    public function setUp()
    {
        parent::setUp();

        $this->answerTransformer = new AnswerTransformer();
        $this->answer = factory(Answer::class)->create();
    }

    public function test_can_transform_answer()
    {
        $transformedAnswer = $this->answerTransformer->transform($this->answer);

        $this->assertInternalType('array', $transformedAnswer);
        $this->assertArrayHasKeys($transformedAnswer, 'id', 'body', 'up_vote', 'down_vote');
    }

    public function test_include_user()
    {
        $user = $this->answerTransformer->includeUser($this->answer);

        $this->assertInternalType('object', $user);
    }

    public function test_include_question()
    {
        $question = $this->answerTransformer->includeQuestion($this->answer);

        $this->assertInternalType('object', $question);
    }
}
