<?php
/**
 * Created by PhpStorm.
 * User: ntimobedyeboah
 * Date: 3/6/17
 * Time: 11:01 AM.
 */
use App\Question;
use App\User;

$factory->define(Question::class, function (Faker\Generator $faker) {
    return [
        'title'   => $faker->sentence,
        'body'    => $faker->paragraph,
        'user_id' => factory(User::class)->create()->id,
    ];
});
