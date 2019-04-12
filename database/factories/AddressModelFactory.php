<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Shop\Addresses\Address;
use App\Shop\Customers\Customer;
use App\Shop\Schools\School;

$factory->define(Address::class, function (Faker\Generator $faker) {

    $customer = factory(Customer::class)->create();
    $school = factory(School::class)->create();

    return [
        'alias' => $faker->word,
        'address_1' => $faker->streetAddress,
        'address_2' => null,
        'zip' => $faker->postcode,
        'city' => $faker->city,
        'province_id' => 1,
        'country_id' => 1,
        'customer_id' => $customer->id,
        'school_id' => $school->id,
        'status' => 1
    ];
});
