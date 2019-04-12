<?php

use Faker\Generator as Faker;
use App\Shop\Schools\School;

$factory->define(School::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        'status' => 1
    ];
});
