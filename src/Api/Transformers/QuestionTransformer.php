<?php

/**
 * Created by PhpStorm.
 * User: ntimobedyeboah
 * Date: 3/12/17
 * Time: 2:45 PM
 */

namespace Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Question;

class QuestionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    public $defaultIncludes = ['user'];

    /**
     * Turn this item object into a generic array
     *
     * @param Question $question
     * @return array
     */
    public function transform(Question $question)
    {
        return [
            'id' => (int)$question->id,
            'title' => $question->title,
            'body' => $question->body
        ];
    }

    /**
     * Include User
     *
     * @param Question $question
     * @return \League\Fractal\ItemResource
     */
    public function includeUser(Question $question)
    {
        $user = $question->user;

        return empty($user) ? null : $this->item($user, new UserTransformer);
    }
}