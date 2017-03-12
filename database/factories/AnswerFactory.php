<?php
/**
 * Created by PhpStorm.
 * User: ntimobedyeboah
 * Date: 3/6/17
 * Time: 11:19 AM
 */
use App\Answer;
use App\User;
use App\Question;

$factory->define(Answer::class, function(Faker\Generator $faker) {
    return [
        'body' => $faker->paragraph,
        'user_id' => factory(User::class)->create()->id,
        'question_id' => factory(Question::class)->create()->id,
        'up_vote' => $faker->randomNumber(),
        'down_vote' => $faker->randomNumber()
    ];
});