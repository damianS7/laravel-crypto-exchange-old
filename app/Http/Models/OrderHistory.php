<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $table = "order_history";
    public $timestamps = false;
    public static $history_limit = 50;

    public static function getUserHistoryFromLastId($user_id, $market_id, $last_id)
    {
        return OrderHistory::where('user_id', $user_id)->where('market_id', $market_id)->where('id', '>', $last_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->limit(OrderHistory::$history_limit)->get();
    }

    public static function getUserHistory($user_id, $market_id)
    {
        return OrderHistory::where('user_id', $user_id)->where('market_id', $market_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->limit(OrderHistory::$history_limit)->get();
    }

    public static function getMarketHistoryFromLastId($market_id, $last_id)
    {
        return OrderHistory::where('market_id', $market_id)->where('id', '>', $last_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->get();
    }

    public static function getMarketHistory($market_id)
    {
        return OrderHistory::where('market_id', $market_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->limit(OrderHistory::$history_limit)->get();
    }
}
