<?php

namespace Tests\Unit;

use Api\Transformers\QuestionTransformer;
use App\Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionTransformerTest extends TestCase
{
    use DatabaseMigrations;

    public $question;

    public $questionTransformer;

    public function setUp()
    {
        parent::setUp();

        $this->question = factory(Question::class)->create();
        $this->questionTransformer = new QuestionTransformer();
    }

    public function test_can_transform_question()
    {
        $transformedQuestion = $this->questionTransformer->transform($this->question);

        $this->assertInternalType('array', $transformedQuestion);
        $this->assertArrayHasKeys($transformedQuestion, 'id', 'title', 'body');
    }

    public function test_include_user()
    {
        $user = $this->questionTransformer->includeUser($this->question);

        $this->assertInternalType('object', $user);
    }
}
