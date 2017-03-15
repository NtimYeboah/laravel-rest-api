<?php

namespace App\Http\Controllers;

use Api\Transformers\AnswerTransformer;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Api\Traits\SendsResponse;
use App\Jobs\AddAnswerJob;

class AnswersController extends Controller
{
    use SendsResponse;

    /**
     * Pagination limit
     */
    const LIMIT = 30;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Question $question
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Question $question)
    {
        $limit = $request->has('limit') ?: AnswersController::LIMIT;

        $answers = $question->answers()->paginate($limit);

        return $this->respondWithCollection($answers, new AnswerTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Question $question
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        try {
            dispatch(new AddAnswerJob($request, $question));
        } catch (\Exception $e) {
            logger()->error('An error occurred whiles storing an answer', [$e->getMessage()]);

            return $this->respondInternalServerError();
        }

        return $this->respondCreated();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Answer $answer
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        try {
            dispatch(new AddAnswerJob($request, null, $answer));
        } catch (\Exception $e) {
            logger()->error('An error occurred whiles storing an answer', [$e->getMessage()]);

            return $this->respondInternalServerError();
        }

        return $this->respondWithSuccess();
    }

    /**
     * Display a single resource
     *
     * @param Question $question
     * @param Answer $answer
     *
     * @return mixed
     */
    public function show(Question $question, Answer $answer)
    {
        $answer = $question->answers()->findOrFail($answer->id);

        return $this->respondWithItem($answer, new AnswerTransformer);
    }
}
