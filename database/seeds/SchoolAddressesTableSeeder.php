<?php

use Illuminate\Database\Seeder;
use App\Shop\Schools\School;
use App\Shop\Addresses\Address;

class SchoolAddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(School::class, 3)->create()->each(function ($school) {
            factory(Address::class, 3)->make()->each(function($address) use ($school) {
                $school->addresses()->save($address);
            });
        });
    }
}
