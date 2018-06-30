<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Coin;
use App\Http\Models\Deposit;
use App\Http\Models\Market;
use App\Http\Models\Order;
use App\Http\Models\OrderHistory;
use App\Http\Models\Pair;
use App\Http\Models\Setting;
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
    private function addOrder($userId, $pairId, $price, $amount, $type)
    {
        // Balance must be checked before put the order
        $order = new Order;
        $order->user_id = $userId;
        $order->pair_id = $pairId;
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

        $order = $this->addOrder(Auth::user()->id, $request->pair_id, $request->price, $request->amount, $request->type);

        if ($order->exists) {
            $response['data'] = $order;
            $response['status'] = 'ok';
            $response['message'] = 'Order added.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Sorry order can not be removed.';
        }

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
        $user_history_last_id = $request->last_market_history_id;
        $user_orders_last_id = $request->last_market_history_id;
        $pair_id = $request->pair_id;
        $user_id = null;

        if (Auth::check()) {
            $user_id = Auth::user()->id;
        }

        $response = [
            'status' => 'ok',
            'message' => '',
            'data' => [
                'market_history' => $this->getMarketHistory($pair_id, $market_history_last_id),
                'order_book' => $this->getOrderBook($pair_id),
                'user_history' => $this->getUserHistory($user_id, $pair_id, $user_history_last_id),
                'user_orders' => $this->getUserOrders($user_id, $pair_id, $user_orders_last_id),
            ],
        ];
        return response()->json($response);
    }

    private function getMarketHistory($pair_id, $last_id = null)
    {
        if ($last_id !== null) {
            return OrderHistory::where('pair_id', $pair_id)->where('id', '>', $last_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->limit('50')->get();
        }

        return OrderHistory::where('pair_id', $pair_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->limit('50')->get();
    }

    private function getUserOrders($user_id, $pair_id, $last_id = null)
    {
        if ($user_id === null) {
            return [];
        }

        if ($last_id !== null) {
            return Order::where('user_id', $user_id)->where('pair_id', $pair_id)->where('id', '>', $last_id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
        }

        return Order::where('user_id', $user_id)->where('pair_id', $pair_id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();
    }

    private function getUserHistory($user_id, $pair_id, $last_id = null)
    {
        if ($user_id === null) {
            return [];
        }

        if ($last_id !== null) {
            return OrderHistory::where('user_id', $user_id)->where('pair_id', $pair_id)->where('id', '>', $last_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->get();
        }

        return OrderHistory::where('user_id', $user_id)->where('pair_id', $pair_id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->get();
    }

    private function getOrderBook($pair_id)
    {
        // Book of open orders for the actual pair
        /*
        Hay que buscar tambien la otra moneda para sumar la cantidad
        BTC/USDT (SE VENDE BTC POR USDT o SE COMPRA USDT POR BTC)
        SELLS (Total BTC)
        BUYS (Total USDT)

        La consulta debe devoler:BTC/USDT
        precio(USDT), cantidad(BTC) total(USDT)
        TRX/BTC
        precio(BTC), cantidad(TRX) total(BTC) y UNION SUM(TRX)

        SELECT oo.type, oo.price as 'price',
        SUM(oo.amount) as 'sum',
        ROUND(SUM(oo.amount)*oo.price, 8) as 'value',
        (SELECT SUM(amount)
        FROM `open_orders`
        WHERE pair_id = 1 AND type='buy') as 'total'
        FROM `open_orders` oo
        WHERE pair_id = 1 AND type='buy'
        GROUP BY price
        ORDER BY price DESC

         */
//$buyOrders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('SUM(price) as "total"'))->where('pair_id', $pair->id)->where('type', 'buy')->groupBy('price')->orderBy('price', 'DESC')->get();
        $buy_orders = Order::select(
            'price', DB::raw('SUM(amount) as "amount"'),
            DB::raw('SUM(price) as "total"'),
            DB::raw('(SELECT SUM(amount) FROM open_orders WHERE pair_id = ' . $pair_id . ' AND type="buy") as total_coins'))
            ->where('pair_id', $pair_id)
            ->where('type', 'buy')
            ->groupBy('price')
            ->orderBy('price', 'DESC')
            ->get();

        $total_buys = Order::selectRaw('SUM(amount) as "total_coins"')->where('pair_id', $pair_id)->where('type', 'buy')->first()->total_coins;

//$sellOrders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('SUM(price) as "total"'))->where('pair_id', $pair->id)->where('type', 'sell')->groupBy('price')->orderBy('price', 'DESC')->get();
        $sell_orders = Order::select(
            'price', DB::raw('SUM(amount) as "amount"'),
            DB::raw('SUM(price) as "total"'),
            DB::raw('(SELECT SUM(amount) FROM open_orders WHERE pair_id = ' . $pair_id . ' AND type="sell") as total_coins'))
            ->where('pair_id', $pair_id)
            ->where('type', 'sell')
            ->groupBy('price')
            ->orderBy('price', 'DESC')
            ->get();

        $total_sells = Order::selectRaw('SUM(amount) as "total_coins"')->where('pair_id', $pair_id)->where('type', 'sell')->first()->total_coins;

        return [
            'buy_orders' => $buy_orders,
            'buy_total_coins' => $total_buys,
            'sell_orders' => $sell_orders,
            'sell_total_coins' => $total_sells,
        ];
    }

    private function getBalance($user_id, $pair_id)
    {
        return [
            'BTC' => '5.0000000',
            'USDT' => '3000.000000',
        ];
    }

    // Returns the user balance for the coin
    private function updateBalances($userId, $coin1, $coin2)
    {
        $b1 = 0.003;
        $b2 = 1.555;
        $depositsCoin1 = Deposit::where('status', 'confirmed')->where('user_id', $userId)->where('coin_id', $coin1->id);
        $depositsCoin2 = Deposit::where('status', 'confirmed')->where('user_id', $userId)->where('coin_id', $coin2->id);
        //$buyOrdersCoin1 = Order::where('type', 'buy')->where('user_id', $userId)->where('coin_id', $coin1->id);
        //$sellOrdersCoin1 = Order::where('type', 'sell')->where('user_id', $userId)->where('coin_id', $coin1->id);
        //$sellHistoryCoin1 = OrderHistory::where('type', 'sell')->where('user_id', $userId)->where('coin_id', $coin1->id);
        //$buyHistoryCoin1 = OrderHistory::where('type', 'sell')->where('user_id', $userId)->where('coin_id', $coin1->id);

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

    public function index(Request $request, $pair = null)
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

        // Get the coin pair symbols
        $coinsPair = explode('-', $pair);
        // Get id from each coin
        // Also firstOrFail will throw 'page dont exist' message in user browser if not founded in db
        $coin1 = Coin::where('symbol', $coinsPair[0])->firstOrFail();
        $coin2 = Coin::where('symbol', $coinsPair[1])->firstOrFail();
        $market = Market::where('coin_id', $coin2->id)->firstOrFail();

        //return $coin1->symbol . ' con id ' . $coin1->id . ' ' . $coin2->symbol . ' con id ' . $coin2->id . ' y market id ' . $market->id;
        $pair = Pair::where('coin_id', $coin1->id)->where('market_id', $market->id)->firstOrFail();

        // Needed settings
        $settings = Setting::all()->keyBy('name');

        // Trade markets (which constains also pairs)
        $markets = Market::select('markets.*', 'coins.symbol')
            ->join('coins', 'markets.coin_id', '=', 'coins.id')
            ->get()->keyBy('symbol');

        // User trade history for the actual coin he is trading
        $user_history = $this->getUserHistory($user_id, $pair->id);

        // Open orders from the user
        $user_orders = $this->getUserOrders($user_id, $pair->id);

        // User balance
        $balance = $this->getBalance($user_id, $pair->id);

        // Market history for the actual pair user is trading
        $market_history = $this->getMarketHistory($pair->id);

        $order_book = $this->getOrderBook($pair->id);

        // Array names
        $names = array('order_book', 'settings', 'market_history', 'markets', 'user_orders', 'user_history', 'pair', 'balance', 'coin1', 'coin2');

        return view('exchange/trade')->with(compact($names));
    }

}
