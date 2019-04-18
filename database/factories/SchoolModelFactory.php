<?php

use Faker\Generator as Faker;
use App\Shop\Schools\School;

$factory->define(School::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'status' => 1
    ];
});
