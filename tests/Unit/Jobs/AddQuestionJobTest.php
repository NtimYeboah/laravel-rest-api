<?php

namespace Tests\Unit;

use App\Jobs\AddQuestionJob;
use App\Question;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AddQuestionJobTest extends TestCase
{
    use DatabaseMigrations;

    public function test_can_create_question()
    {
        $this->setAuthUser();

        $question = factory(Question::class)->make(['title' => 'Unit testing laravel']);

        $this->request->merge($question->toArray());

        $createdQuestion = dispatch(new AddQuestionJob($this->request, new Question()));

        $this->assertInstanceOf(Question::class, $createdQuestion);
        $this->assertEquals('Unit testing laravel', $createdQuestion->title);
        $this->assertNotNull($createdQuestion->body);
        $this->assertInstanceOf(User::class, $createdQuestion->user);
    }

    public function test_can_update_question()
    {
        $this->setAuthUser();

        $question = factory(Question::class)->create();

        $title = 'Is Lavavel the framework for web artisans?';
        $question['title'] = $title;

        $this->request->merge($question->toArray());

        $updatedQuestion = dispatch(new AddQuestionJob($this->request, $question));

        $this->assertInstanceOf(Question::class, $updatedQuestion);
        $this->assertEquals($title, $updatedQuestion->title);
    }
}
