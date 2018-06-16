<?php

use Faker\Generator as Faker;

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

$factory->define(App\Coin::class, function (Faker $faker) {
    return [
        'symbol' => str_random(4),
        'name' => $faker->name,
        'min_deposit' => $faker->randomFloat(8, 0, 100),
        'min_withdrawal' => $faker->randomFloat(8, 0, 100),
        'fee_withdrawal' => $faker->randomFloat(8, 0, 100)
    ];
});
