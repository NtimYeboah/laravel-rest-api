<?php

namespace App\Http\Controllers;

use Api\Traits\SendsResponse;
use Api\Transformers\QuestionTransformer;
use App\Http\Requests\QuestionRequest;
use App\Jobs\AddQuestionJob;
use App\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    use SendsResponse;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ?: 30;

        $questions = Question::paginate($limit);

        return $this->respondWithCollection($questions, new QuestionTransformer(), ['questions, comments']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionRequest|Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        try {
            dispatch(new AddQuestionJob($request, new Question()));
        } catch (\Exception $e) {
            return $this->respondInternalServerError();
        }

        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);

        return $this->respondWithItem($question, new QuestionTransformer());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
