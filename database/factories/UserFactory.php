<?php

use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'fullname' => ($fullname = $faker->name), 'email' => ($email=$faker->unique()->safeEmail),
        'password' => Hash::make('password'), 'remember_token' => str_random(10),
        'professional' => $faker->randomElement([true, false]), 'token' => Hash::make($email.str_random(25).$fullname),
        'addressOne' => $faker->unique()->address, 'addressTwo' => $faker->unique()->buildingNumber,
        'phone' => $faker->unique()->e164PhoneNumber, 'city' => $faker->unique()->city,
        'zipcode' => $faker->unique()->postcode, 'reference' => uniqid('@KEY').'@REF@'. str_random(5)
    ];
});
