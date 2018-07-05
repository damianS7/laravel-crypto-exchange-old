<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Coin;
use App\Http\Models\Deposit;
use App\Http\Models\Market;
use App\Http\Models\Order;
use App\Http\Models\OrderHistory;
use App\Http\Models\Setting;
use App\Http\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

// Beautify this class
class TradeController extends Controller
{
    /**
     * Add a new open order
     * @return \App\Http\Models\Order
     */
    private function addOrder($user_id, $market_id, $price, $amount, $type)
    {
        // Balance must be checked before put the order
        $order = new Order;
        $order->user_id = $user_id;
        $order->market_id = $market_id;
        $order->price = $price;
        $order->amount = $amount;
        $order->type = $type;
        $order->created_at = date('Y-m-d H:i:s');
        $order->save();
        return $order;
    }

    /**
     * Delete given order id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxAddOrder(Request $request)
    {
        $response = [
            "status" => "error",
            "message" => "You can not add order because you are not logged in!.",
            "data" => "",
        ];

        // Only auth users are allowed from here
        if (!Auth::check()) {
            // Non logged users can't pass
            return response()->json($response);
        }

        $order = $this->addOrder(Auth::user()->id, $request->market_id, $request->price, $request->amount, $request->type);

        if ($order->exists) {
            $response['data'] = $order;
            $response['status'] = 'ok';
            $response['message'] = 'Order added.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Sorry order can not be removed.';
        }

        //$response['message'] = 'Insuficient balance.';

        return response()->json($response);
    }

    /**
     * Delete given order id
     * @return \App\Http\Models\Order
     */
    private function deleteOrder($orderId)
    {
        $order = Order::find($orderId);
        $order->delete();
        return $order;
    }

    /**
     * Delete given order id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxDeleteOrder(Request $request)
    {
        $response = [
            "status" => "error",
            "message" => "You can not add order because you are not logged in!.",
            "data" => "",
        ];

        // Only auth users are allowed from here
        if (!Auth::check()) {
            // Non logged users can't pass
            return response()->json($response);
        }

        $order = $this->deleteOrder($request->order_id);

        if ($order) {
            $response['status'] = 'ok';
            $response['message'] = 'Order removed.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Order couldn\'t be removed.';
        }

        $response['data'] = $order;
        return response()->json($response);
    }

    /**
     *
     * This returns updated data so we can update the website
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxUpdateView(Request $request)
    {
        $market_history_last_id = $request->last_market_history_id;
        $user_history_last_id = $request->last_user_history_id;
        $user_orders_last_id = $request->last_user_orders_id;
        $market_id = $request->market_id;
        $user_id = null;

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }

        $response = [
            'status' => 'ok',
            'message' => '',
            'received' => '',
            'data' => [
                'market_history' => $this->getMarketHistory($market_id, $market_history_last_id),
                'order_book' => $this->getOrderBook($market_id),
                'user_history' => $this->getUserHistory($user_id, $market_id, $user_history_last_id),
                'user_orders' => $this->getUserOrders($user_id, $market_id, $user_orders_last_id),
            ],
        ];
        return response()->json($response);
    }

    private function getMarketHistory($market_id, $last_id = null)
    {
        if ($last_id !== null) {
            return OrderHistory::where('market_id', $market_id)->where('id', '>', $last_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->get();
        }

        //SELECT * FROM `order_history` WHERE market_id = 1 ORDER BY `filled_at` DESC, id ASC
        return OrderHistory::where('market_id', $market_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->limit('50')->get();
    }

    private function getUserOrders($user_id, $market_id, $last_id = null)
    {
        if ($user_id === null) {
            return [];
        }

        if ($last_id !== null) {
            return Order::where('user_id', $user_id)->where('market_id', $market_id)->where('id', '>', $last_id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->limit(50)->get();
        }

        return Order::where('user_id', $user_id)->where('market_id', $market_id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->limit(50)->get();
    }

    private function getMarkets()
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

    private function getUserHistory($user_id, $market_id, $last_id = null)
    {
        if ($user_id === null) {
            return [];
        }

        if ($last_id !== null) {
            return OrderHistory::where('user_id', $user_id)->where('market_id', $market_id)->where('id', '>', $last_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->get();
        }

        return OrderHistory::where('user_id', $user_id)->where('market_id', $market_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->get();
    }

    private function getOrderBook($market_id)
    {
        $limit = 25;
        //select type,price, SUM(amount) as "amount", ROUND(SUM(amount)*price, 8) as "total" from `open_orders` where `market_id` = 1 group by price,type

        // Book of open orders for the actual market

        $buy_orders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('ROUND(SUM(amount)*price, 8) as "total"'))->where('market_id', $market_id)
            ->where('type', 'buy')
            ->groupBy('price')
            ->orderBy('price', 'DESC')
            ->limit($limit)
            ->get()
            ->keyBy('price');

        $sell_orders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('ROUND(SUM(amount)*price, 8) as "total"'))->where('market_id', $market_id)
            ->where('type', 'sell')
            ->groupBy('price')
            ->orderBy('price', 'DESC')
            ->limit($limit)
            ->get()
            ->keyBy('price');

        return [
            'buy' => $buy_orders,
            'sell' => $sell_orders,
        ];

    }

    /**
     *
     * @param  $user_id
     * @param  Array $coins_id
     * @return Array with the coins balances
     */
    private function getBalances($user_id, $coins_id)
    {
        $balances = [];
        foreach ($coins_id as $coin_id) {
            $symbol = Coin::select('symbol')->where('id', $coin_id)->first()->symbol;
            $balances[$symbol] = $this->getBalance($user_id, $coin_id);
        }
        return $balances;
    }

    /**
     *
     * @param  $user_id
     * @param  $coin_id
     * @return $balance with the coin balance
     */
    private function getBalance($user_id, $coin_id)
    {
        $deposits = Deposit::select(DB::raw('SUM(amount) as "amount"'))->where('user_id', $user_id)->where('coin_id', $coin_id)->where('status', 'confirmed')->first();

        $withdrawals = Withdrawal::select(DB::raw('SUM(amount) as "amount"'))->where('user_id', $user_id)->where('coin_id', $coin_id)->where('status', 'confirmed')->first();

        //$history = OrderHistory::select(DB::raw('SUM(amount) as "amount"'))->where('user_id', $user_id)->where('coin_id', $coin_id)->where('status', 'confirmed')->first();

        //$orders = Order::select(DB::raw('SUM(amount) as "amount"'))->where('user_id', $user_id)->where('coin_id', $coin_id)->where('status', 'confirmed')->first();

        //$balance = $deposits->amount - $withdrawals->amount - $orders->amount - $history->amount;
        $balance = $deposits->amount - $withdrawals->amount;

        return $balance;
    }

    // Returns the user balance for the coin
    private function updateBalances($user_id, $coin1, $coin2)
    {
        $b1 = 0.003;
        $b2 = 1.555;
        $depositsCoin1 = Deposit::where('status', 'confirmed')->where('user_id', $user_id)->where('coin_id', $coin1->id);
        $depositsCoin2 = Deposit::where('status', 'confirmed')->where('user_id', $user_id)->where('coin_id', $coin2->id);
        //$buyOrdersCoin1 = Order::where('type', 'buy')->where('user_id', $user_id)->where('coin_id', $coin1->id);
        //$sellOrdersCoin1 = Order::where('type', 'sell')->where('user_id', $user_id)->where('coin_id', $coin1->id);
        //$sellHistoryCoin1 = OrderHistory::where('type', 'sell')->where('user_id', $user_id)->where('coin_id', $coin1->id);
        //$buyHistoryCoin1 = OrderHistory::where('type', 'sell')->where('user_id', $user_id)->where('coin_id', $coin1->id);

        //foreach ($buyHistoryCoin1 as $bho) {
        //    $b1 += $bho->amount;
        //}
        //return $deposits-$openOrders-$historyOrders;

        return array(
            $coin1->symbol => $b1,
            $coin2->symbol => $b2,
        );
    }

    public function changeTheme()
    {
        if (Cookie::get('theme') == 'light') {
            Cookie::queue('theme', 'dark', 60 * 24 * 4);
        } else {
            Cookie::queue('theme', 'light', 60 * 24 * 4);
        }
        //return redirect ('trade');
        return redirect(url()->previous());
    }

    private function pairExists()
    {
        //$search = Pair::find();
        //if exists return true else false
    }

    public function index(Request $request, $market = null)
    {
        // Check if cookie theme is set
        if (empty(Cookie::get('theme'))) {
            // set cookie for color theme
            Cookie::queue('theme', 'light', 60 * 24 * 4);
        }

        $user_id = null;
        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }

        // Get the coin market symbols
        $marketGET = explode('-', $market);
        // Get id from each coin
        // Also firstOrFail will throw 'page dont exist' message in user browser if not founded in db
        $coin1 = Coin::where('symbol', $marketGET[0])->firstOrFail();
        $coin2 = Coin::where('symbol', $marketGET[1])->firstOrFail();
        $market = Market::where('traded_coin_id', $coin1->id)->where('market_coin_id', $coin2->id)->firstOrFail();

        //return $coin1->symbol . ' con id ' . $coin1->id . ' ' . $coin2->symbol . ' con id ' . $coin2->id . ' y market id ' . $market->id;
        //$pair = Pair::where('coin_id', $coin1->id)->where('market_id', $market->id)->firstOrFail();

        // Needed settings
        $settings = Setting::all()->keyBy('name');

        // Trade markets (which constains also pairs)
        $markets = $this->getMarkets();

        // User trade history for the actual coin he is trading
        $user_history = $this->getUserHistory($user_id, $market->id);

        // Open orders from the user
        $user_orders = $this->getUserOrders($user_id, $market->id);

        // User balance
        $balance = $this->getBalances($user_id, [1, 2]);

        // Market history for the actual pair user is trading
        $market_history = $this->getMarketHistory($market->id);

        $order_book = $this->getOrderBook($market->id);

        // Array names
        $names = array('order_book', 'settings', 'market_history', 'markets', 'user_orders', 'user_history', 'pair', 'balance', 'coin1', 'coin2', 'market');
        return view('exchange/trade')->with(compact($names));
    }

}
