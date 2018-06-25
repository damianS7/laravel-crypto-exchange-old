<?php

use App\Http\Models\Coin;
use App\Http\Models\Deposit;
use App\Http\Models\Market;
use App\Http\Models\Order;
use App\Http\Models\OrderHistory;
use App\Http\Models\Pair;
use App\Http\Models\Wallet;
use App\User;
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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'), // secret
        'remember_token' => str_random(10),
        'privileges' => $faker->randomElement(['user', 'admin']),
    ];
});

$factory->define(Coin::class, function (Faker $faker) {
    return [
        'symbol' => str_random(4),
        'name' => $faker->name,
        'min_deposit' => $faker->randomFloat(8, 0, 1000),
        'min_withdrawal' => $faker->randomFloat(8, 0, 1000),
        'fee_withdrawal' => $faker->randomFloat(8, 0, 1000),
    ];
});

$factory->define(Market::class, function (Faker $faker) {
    return [
        'coin_id' => $faker->randomElement(Coin::pluck('id')->toArray()),
    ];
});

$factory->define(Pair::class, function (Faker $faker) {
    return [
        'coin_id' => $faker->randomElement(Coin::pluck('id')->toArray()),
        'market_id' => $faker->randomElement(Market::pluck('id')->toArray()),
    ];
});

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomElement(User::pluck('id')->toArray()),
        'coin_id' => $faker->randomElement(Coin::pluck('id')->toArray()),
        'address' => str_random(64),
    ];
});

$factory->define(Deposit::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomElement(User::pluck('id')->toArray()),
        'coin_id' => $faker->randomElement(Coin::pluck('id')->toArray()),
        'wallet_id' => $faker->randomElement(Wallet::pluck('id')->toArray()),
        'amount' => $faker->randomFloat(8, 0, 10000),
        'tx' => str_random(64),
        'date' => date('Y-m-d H:i:s', rand(1260099000, 1600000000)),
    ];
});

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomElement(User::pluck('id')->toArray()),
        'pair_id' => $faker->randomElement(Pair::pluck('id')->toArray()),
        'price' => $faker->randomFloat(8, 0, 10000),
        'amount' => $faker->randomFloat(8, 0, 10000),
        'type' => $faker->randomElement(['buy', 'sell']),
        'created_at' => date('Y-m-d H:i:s', rand(1260099000, 1600000000)),
    ];
});

$factory->define(OrderHistory::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomElement(User::pluck('id')->toArray()),
        'pair_id' => $faker->randomElement(Pair::pluck('id')->toArray()),
        'price' => $faker->randomFloat(8, 0, 10000),
        'amount' => $faker->randomFloat(8, 0, 10000),
        'type' => $faker->randomElement(['buy', 'sell']),
        'date' => date('Y-m-d H:i:s', rand(1260099000, 1600000000)),
    ];
});
