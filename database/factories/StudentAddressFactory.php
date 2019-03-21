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

$factory->define(App\Models\StudentAddress::class, function (Faker\Generator $faker) {

    return [
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'houseNo' => rand(0, 121),
        'line_1' => $faker->streetName,
        'line_2' => $faker->streetAddress
    ];
});
