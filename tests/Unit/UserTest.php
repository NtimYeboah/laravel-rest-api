<?php

namespace Tests\Unit;

use App\Question;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_has_many_questions()
    {
        $user = factory(User::class)->create();

        $question = factory(Question::class, 10)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(Question::class, $question->first());
        $this->assertCount(10, $user->questions);
    }
}
