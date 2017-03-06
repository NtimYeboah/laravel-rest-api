<?php
/**
 * Created by PhpStorm.
 * User: ntimobedyeboah
 * Date: 3/6/17
 * Time: 11:43 AM
 */
use App\Comment;
use App\User;

$factory->define(Comment::class, function(Faker\Generator $faker) {
    return [
        'body' => $faker->paragraph,
        'user_id' => factory(User::class)->create()->id,
        'commentable_id' => null,
        'commentable_type' => null
    ];
});