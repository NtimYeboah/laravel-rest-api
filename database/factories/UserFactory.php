<?php
/**
 * Created by PhpStorm.
 * User: ntimobedyeboah
 * Date: 3/6/17
 * Time: 10:54 AM.
 */
use App\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->safeEmail,
    ];
});
