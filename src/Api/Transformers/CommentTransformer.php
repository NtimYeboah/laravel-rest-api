<?php

/**
 * Created by PhpStorm.
 * User: ntimobedyeboah
 * Date: 3/12/17
 * Time: 2:48 PM
 */
namespace Api\Transformers;

use League\Fractal\TransformerAbstract;
use App\Comment;

class CommentTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    public $defaultIncludes = ['user', 'commentable'];


    /**
     * Turn this item object into a generic array
     *
     * @param Comment $comment
     * @return array
     */
    public function transform(Comment $comment)
    {
        return [
            'id' => (int)$comment->id,
            'body' => $comment->body,
            'commentable_type' => $comment->commentable_type
        ];
    }

    /**
     * Include User
     *
     * @param Comment $comment
     * @return \League\Fractal\ItemResource
     */
    public function includeUser(Comment $comment)
    {
        $user = $comment->user;

        return empty($user) ? null : $this->item($user, new UserTransformer);
    }
}