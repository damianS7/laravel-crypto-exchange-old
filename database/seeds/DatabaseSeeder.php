<?php

use App\Http\Models\Coin;
use App\Http\Models\Market;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        try {
            DB::table('settings')->insert([
                ['name' => 'buy_fee', 'value' => '0.01'],
                ['name' => 'sell_fee', 'value' => '0.01'],
                ['name' => 'process_withdrawal', 'value' => '5'],
            ]);
        } catch (Illuminate\Database\QueryException $e) {

        }

        try {
            DB::table('users')->insert([
                'email' => 'josepwnz@gmail.com',
                'privileges' => 'admin',
                'password' => bcrypt('123456'),
            ]);

            DB::table('coins')->insert([
                [
                    'symbol' => 'BTC',
                    'name' => 'Bitcoin',
                    'min_deposit' => $faker->randomFloat(8, 0, 1000),
                    'min_withdrawal' => $faker->randomFloat(8, 0, 1000),
                    'fee_withdrawal' => $faker->randomFloat(8, 0, 1000),
                ],
                [
                    'symbol' => 'USDT',
                    'name' => 'USDTether',
                    'min_deposit' => $faker->randomFloat(8, 0, 1000),
                    'min_withdrawal' => $faker->randomFloat(8, 0, 1000),
                    'fee_withdrawal' => $faker->randomFloat(8, 0, 1000),
                ],
            ]);

            DB::table('markets')->insert([
                'coin_id' => Coin::where('symbol', 'USDT')->first()->id,
            ]);

            $btc = Coin::where('symbol', 'BTC')->first();
            $usdt = Coin::where('symbol', 'USDT')->first();
            $market = Market::where('coin_id', $usdt->id)->first();

            DB::table('pairs')->insert([
                'coin_id' => $btc->id,
                'market_id' => $market->id,
            ]);
        } catch (Illuminate\Database\QueryException $e) {

        }

        //factory('App\User', 3)->create();
        //factory('App\Http\Models\Coin', 100)->create();
        //factory('App\Http\Models\Market', 5)->create();
        //factory('App\Http\Models\Pair', 10)->create();
        //factory('App\Http\Models\Wallet', 200)->create();
        //factory('App\Http\Models\Deposit', 400)->create();
        //factory('App\Http\Models\Order', 1000)->create();
        factory('App\Http\Models\OrderHistory', 2000)->create();
    }
}
