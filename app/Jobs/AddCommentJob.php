<?php

namespace App\Jobs;

use App\Comment;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Concerns\HasRelationships;

class AddCommentJob
{
    use HasRelationships;

    /**
     * @var Request
     */
    private $request;
    /**
     * @var Comment
     */
    private $comment;
    /**
     * @var Question
     */
    private $question;

    /**
     * Create a new job instance.
     *
     * @param Request $request
     * @param Question $question
     * @param Comment $comment
     */
    public function __construct(Request $request, Question $question = null, Comment $comment = null)
    {
        $this->request = $request;
        $this->comment = $comment;
        $this->question = $question;
    }

    /**
     * Execute the job.
     *
     * @return Comment
     */
    public function handle()
    {
        return $this->createComment();
    }

    /**
     * Create comment
     *
     * @return Comment
     */
    public function createComment()
    {
        if (null === $this->comment) {
            $this->comment = new Comment();
            $this->comment->user()->associate($this->request->user());
            $this->comment->commentable_id = $this->question->id;
            $this->comment->commentable_type = self::getActualClassNameForMorph(Question::class);
        }

        foreach ($this->comment->getFillable() as $fillable) {
            if ($this->request->has($fillable)) {
                $this->comment->{$fillable} = $this->request->get($fillable);
            }
        }

        $this->comment->save();

        return $this->comment;
    }
}
