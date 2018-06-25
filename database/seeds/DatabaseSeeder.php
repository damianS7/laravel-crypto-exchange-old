<?php

use Illuminate\Database\Seeder;
use App\Http\Models\Coin;
use App\Http\Models\Market;

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
            DB::table('users')->insert([
                        'email' => 'josepwnz@gmail.com',
                        'privileges' => 'admin',
                        'password' => bcrypt('123456')
                    ]);

                    
            DB::table('coins')->insert([
                                'symbol' => 'BTC',
                                'name' => 'Bitcoin',
                                'min_deposit' => $faker->randomFloat(8, 0, 1000),
                                'min_withdrawal' => $faker->randomFloat(8, 0, 1000),
                                'fee_withdrawal' => $faker->randomFloat(8, 0, 1000)
                            ]);
                    
            DB::table('coins')->insert([
                                'symbol' => 'USDT',
                                'name' => 'USDTether',
                                'min_deposit' => $faker->randomFloat(8, 0, 1000),
                                'min_withdrawal' => $faker->randomFloat(8, 0, 1000),
                                'fee_withdrawal' => $faker->randomFloat(8, 0, 1000)
                            ]);
                    
            DB::table('markets')->insert([
                                'coin_id' => Coin::where('symbol', 'USDT')->first()->id,
                            ]);
                    
            DB::table('pairs')->insert([
                                'coin_id' => Coin::where('symbol', 'BTC')->first()->id,
                                'market_id' => Coin::where('symbol', 'USDT')->first()->id,
                            ]);
        } catch (Illuminate\Database\QueryException $e) {
        }
        
      
        //factory('App\User', 3)->create();
        factory('App\Http\Models\Coin', 30)->create();
        factory('App\Http\Models\Market', 4)->create();
        factory('App\Http\Models\Pair', 20)->create();
        factory('App\Http\Models\Wallet', 200)->create();
        factory('App\Http\Models\Deposit', 400)->create();
        factory('App\Http\Models\Order', 1000)->create();
        factory('App\Http\Models\OrderHistory', 500)->create();
    }
}
