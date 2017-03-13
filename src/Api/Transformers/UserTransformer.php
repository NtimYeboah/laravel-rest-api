<?php

/**
 * Created by PhpStorm.
 * User: ntimobedyeboah
 * Date: 3/12/17
 * Time: 2:47 PM.
 */

namespace Api\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id'        => (int) $user->id,
            'firstname' => $user->first_name,
            'lastname'  => $user->last_name,
            'fullname'  => "{$user->first_name} {$user->last_name}",
            'email'     => $user->email,
        ];
    }
}
