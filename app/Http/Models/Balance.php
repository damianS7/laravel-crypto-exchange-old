<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    public $timestamps = false;

    /**
     *
     * @param  $user_id
     * @param  $coin_id
     * @return $balance with the coin balance
     */
    public static function getBalance($user_id, $coin_id)
    {
        return Balance::where('user_id', $user_id)->where('coin_id', $coin_id)->first();
    }

    public static function getMarketBalances($user_id, $market_id)
    {

    }

}
