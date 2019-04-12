<?php

use Illuminate\Database\Seeder;
use App\Shop\Schools\School;


class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(School::class)->create();
    }
}
