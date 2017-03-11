<?php

namespace App\Jobs;

use App\Question;
use Illuminate\Http\Request;


class AddQuestionJob
{
    /**
     * @var Request
     */
    private $request;
    /**
     * @var Question
     */
    private $question;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     * @param Question $question
     */
    public function __construct(Request $request, Question $question)
    {
        $this->request = $request;
        $this->question = $question;
    }

    /**
     * Execute the job.
     *
     * @return Question
     */
    public function handle()
    {
        return $this->createQuestion();
    }

    /**
     * Create question and save it to the database
     */
    private function createQuestion()
    {
        foreach($this->question->getFillable() as $fillable) {
            if ($this->request->has($fillable)) {
                $this->question->{$fillable} = $this->request->get($fillable);
            }
        }

        $this->question->save();

        return $this->question;
    }
}
