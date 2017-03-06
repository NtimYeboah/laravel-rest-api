<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Question;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
}
