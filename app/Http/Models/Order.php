<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $table = "open_orders";
    protected $fillable = ['created_at'];
    public $timestamps = false;
    protected static $book_limit = 25;
    protected static $user_order_limit = 50;

    // return true if order is deleted.
    public static function deleteOrder($order_id)
    {
        $order = Order::find($order_id);

        if ($order !== null) {
            $order->delete();
            return true;
        }

        return false;
    }

    public static function getUserOrdersFromLastId($user_id, $market_id, $last_id)
    {
        return Order::where('user_id', $user_id)->where('market_id', $market_id)->where('id', '>', $last_id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->limit(Order::$user_order_limit)->get();
    }

    public static function getUserOrders($user_id, $market_id)
    {
        return Order::where('user_id', $user_id)->where('market_id', $market_id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->limit(Order::$user_order_limit)->get();
    }

    //select type,price, SUM(amount) as "amount", ROUND(SUM(amount)*price, 8) as "total" from `open_orders` where `market_id` = 1 group by price,type
    public static function getOrderBook($market_id, $book)
    {
        $orders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('ROUND(SUM(amount)*price, 8) as "total"'))->where('market_id', $market_id)
            ->where('type', $book)
            ->groupBy('price')
            ->orderBy('price', 'DESC')
            ->limit(Order::$book_limit)
            ->get();

        return $orders->keyBy('price');
    }
}
