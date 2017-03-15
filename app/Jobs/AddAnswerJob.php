<?php

namespace App\Jobs;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AddAnswerJob
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Answer
     */
    private $answer;
    /**
     * @var Question
     */
    private $question;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     * @param Question $question
     * @param Answer $answer
     */
    public function __construct(Request $request, Question $question = null, Answer $answer = null)
    {
        $this->request = $request;
        $this->answer = $answer;
        $this->question = $question;
    }

    /**
     * Execute the job.
     *
     * @return Answer
     */
    public function handle()
    {
        return $this->createAnswer();
    }

    /**
     * Create answer
     *
     * @return Answer
     */
    private function createAnswer()
    {
        if (null === $this->answer) {
            $this->answer = new Answer();
            $this->answer->user()->associate($this->request->user());

            $this->answer->question()->associate($this->question);
        }

        foreach($this->answer->getFillable() as $fillable) {
            if ($this->request->has($fillable)) {
                $this->answer->{$fillable} = $this->request->get($fillable);
            }
        }

        $this->answer->save();

        return $this->answer;
    }
}
