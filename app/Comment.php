<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body', 'user_id', 'commentable_id', 'commentable_type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
