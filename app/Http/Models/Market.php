<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Market extends Model
{
    public $timestamps = false;

    public static function getMarket($coin_id1, $coin_id2)
    {
        return Market::where('traded_coin_id', $coin_id1)->where('market_coin_id', $coin_id2)->first();
    }

    public static function getMarkets()
    {
        //SELECT t1.id,(SELECT subt1.symbol FROM coins subt1 WHERE subt1.id = t1.traded_coin_id) as currency_symbol, t1.traded_coin_id, t2.symbol as market_symbol, t1.market_coin_id, t1.status, t1.visible, ROUND(t3.price,3) as price FROM `markets` t1 INNER JOIN coins t2 ON t1.market_coin_id = t2.id LEFT JOIN market_stats t3 ON t3.market_id = t1.id ORDER BY market_symbol ASC

        $sql = Market::select('t1.id', DB::raw('(SELECT subt1.symbol FROM coins subt1 WHERE subt1.id = t1.traded_coin_id) as coin_symbol'), 't1.traded_coin_id', 't2.symbol as market_symbol', 't1.market_coin_id', 't1.status', 't1.visible', 't3.price', DB::raw('ROUND(t3.volume24h, 3) as volume24h'))
            ->from('markets as t1')
            ->join('coins as t2', 't1.market_coin_id', 't2.id')
            ->leftJoin('market_stats as t3', 't1.id', 't3.market_id')
            ->orderBy('market_symbol', 'ASC')
            ->orderBy('coin_symbol', 'ASC');

        return $sql->get()->groupBy('market_symbol');

    }

    public static function exists($coin_id1, $coin_id2)
    {
        $market = Market::where('traded_coin_id', $coin_id1)->where('market_coin_id', $coin_id2)->first();

        if ($market === null) {
            return false;
        }

        return true;
    }
}
