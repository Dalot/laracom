<?php

use Faker\Generator as Faker;
use App\Shop\Professors\Professor;

$factory->define(Professor::class, function (Faker $faker) {
    return [
        'name' => 'Professor',
        'school_id' => 1,
        'employee_id' => 3,
    ];
});
