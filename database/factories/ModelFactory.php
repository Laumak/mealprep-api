<?php

use App\User;
use App\Week;

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
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Week::class, function (Faker\Generator $faker) {
    return [
        'number'  => $faker->numberBetween($min = 1, $max = 52),
        'year'    => $faker->numberBetween($min = 2015, $max = 2017),
        'user_id' => factory(User::class)->create()->id,
    ];
});
