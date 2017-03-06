<?php

namespace Tests\Unit;

use App\Answer;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AnswerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_answer_belongs_to_user()
    {
        $user = factory(User::class)->create();

        $answer = factory(Answer::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Answer::class, $answer);
        $this->assertEquals(1, count($answer->user));
    }
}
