<?php

namespace Tests\Unit;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use DatabaseMigrations;

    public function test_question_belongs_to_user()
    {
        $user = factory(User::class)->create();

        $question = factory(Question::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Question::class, $question);
        $this->assertEquals(1, count($question->user));
    }

    public function test_question_has_many_answers()
    {
        $question = factory(Question::class)->create();

        $answers = factory(Answer::class, 5)->create(['question_id' => $question->id]);

        $this->assertInstanceOf(Answer::class, $answers->first());
        $this->assertEquals(5, count($question->answers));
    }
}
