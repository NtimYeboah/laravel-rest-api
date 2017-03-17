<?php

namespace App\Http\Controllers;

use Api\Transformers\CommentTransformer;
use App\Comment;
use App\Jobs\AddCommentJob;
use App\Question;
use Illuminate\Http\Request;
use Api\Traits\SendsResponse;

class CommentsController extends Controller
{
    use SendsResponse;

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

        $limit = $request->has('limit') ?: CommentsController::LIMIT;

        $comments = $question->comments()->paginate($limit);

        return $this->respondWithCollection($comments, new CommentTransformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Question $question
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Question $question)
    {
        try {
            dispatch(new AddCommentJob($request, $question));
        } catch (\Exception $e) {
            logger()->error('An error occurred whiles adding the comment', [$e->getMessage()]);

            return $this->respondInternalServerError();
        }

        return $this->respondCreated();
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @param Comment $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Comment $comment)
    {
        $comment = Comment::findOrFail($comment->id);

        return $this->respondWithItem($comment, new CommentTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Comment $comment
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            dispatch(new AddCommentJob($request, null, $comment));
        } catch (\Exception $e) {
            logger()->error('An error occurred whiles updating the comment', [$e->getMessage()]);

            return $this->respondInternalServerError();
        }

        return $this->respondCreated();
    }
}
