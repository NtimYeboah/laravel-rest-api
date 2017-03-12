<?php

/**
 * Created by PhpStorm.
 * User: ntimobedyeboah
 * Date: 3/12/17
 * Time: 2:49 PM
 */
namespace Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Answer;

class AnswerTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    public $defaultIncludes = ['user', 'question'];


    /**
     * Turn this item object into a generic array
     *
     * @param Answer $answer
     * @return array
     */
    public function transform(Answer $answer)
    {
        return [
            'id' => (int)$answer->id,
            'body' => $answer->body,
            'up_vote' => $answer->up_vote,
            'down_vote' => $answer->down_vote
        ];
    }

    /**
     * Include User
     *
     * @param Answer $answer
     * @return \League\Fractal\ItemResource
     */
    public function includeUser(Answer $answer)
    {
        $user = $answer->user;

        return empty($user) ? null : $this->item($user, new UserTransformer);
    }

    /**
     * Include Question
     *
     * @param Answer $answer
     * @return \League\Fractal\ItemResource
     */
    public function includeQuestion(Answer $answer)
    {
        $question = $answer->question;

        return empty($question) ? null : $this->item($question, new QuestionTransformer);
    }
}