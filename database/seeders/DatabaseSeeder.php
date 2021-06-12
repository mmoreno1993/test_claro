<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\SendEmail;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $country = Country::factory(50)->create();
        $state = State::factory(50)->create();
        $city = City::factory(50)->create();
        $user = User::factory(50)->create();
        $sendEmail = SendEmail::factory(50)->create();
    }
}
