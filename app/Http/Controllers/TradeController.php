<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Models\Balance;
use App\Http\Models\Coin;
use App\Http\Models\Market;
use App\Http\Models\Order;
use App\Http\Models\OrderHistory;
use App\Http\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

// Beautify this class
class TradeController extends Controller
{
    // return the total amount filled
    // if total_order == amount filled then its full filled
    // fill order if prices match or below
    private function fillOrder($open_order)
    {
        if ($open_order == 'buy') {
            $orders = Order::where('market_id', $open_order->market_id)->where('type', 'sell')->where('price', '<=', $open_order->price)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');

            foreach ($orders as $order) {
                fill($open_order, $order);
            }
        }

        if ($open_order == 'sell') {
            $orders = Order::where('market_id', $open_order->market_id)->where('type', 'buy')->where('price', '>=', $open_order->price)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC');

        }

        // Cancel open order if fully filled

        // Update open order if partially filled
    }

    private function fill($order_to_fill, $order_from_book)
    {
        // If the order from book has more coins than we need ...
        if ($order_from_book->amount >= $order_to_fill->amount) {
            $order_from_book->amount -= $order_to_fill->amount;
            $order_to_fill->amount = 0;
        }

        if ($order_from_book->amount < $order_to_fill->amount) {
            // Wall filled
            $order_from_book->delete();
            $order_to_fill->amount -= $order_from_book->amount;
        }

    }

    // create a order history for a buy or sell
    private function createOrderHistory()
    {
        // Create 2 different orders in history
        // one for the seller, one for the buyer
        // but only show the filled in the market history
        // we may need another table filled_orders and order/user_history
    }

    // check if the user can set this order
    // hasBalance()?
    private function canSetOrder($order)
    {
        $market = Market::where('id', $order->market_id)->first();
        // Check if market is open
        if ($market->status != 'resumed') {
            //return 'Can\'t set an order when market is suspended.';
        }

        // Check if it has enough balance
        if ($order->type == 'sell') {
            $coin1_balance = Balance::getBalance($market->traded_coin_id, $order->user_id);
            $total_needed = $order->price * $order->amount;

            if ($coin1_balance->avaliable >= $total_needed) {
                return true;
            }

        }

        if ($order->type == 'buy') {
            $coin2_balance = Balance::getBalance($market->market_coin_id, $order->user_id);
            $total_needed = $order->price * $order->amount;

            if ($coin2_balance->avaliable >= $total_needed) {
                return true;
            }
        }

        return 'Insuficient balance.';
    }

    private function updateBalance($order, $open = true)
    {
        $order_total = $order->amount * $order->price;
        $market = Market::where('id', $order->market_id)->first();

        $balance1 = Balance::where('coin_id', $market->traded_coin_id)->where('user_id', $order->user_id)->first();
        $balance2 = Balance::where('coin_id', $market->market_coin_id)->where('user_id', $order->user_id)->first();

        // Buy sums
        if ($order->type == 'buy') {
            $balance2->avaliable -= $order_total;
            $balance2->save();

            if (!$open) {
                $balance2->total -= $order_total;

                $balance1->avaliable += $order_total;
                $balance1->total += $order_total;
                $balance1->save();

            }
        }

        // Sell substract
        if ($order->type == 'sell') {
            $balance1->avaliable -= $order_total;
            $balance1->save();

            if (!$open) {
                $balance1->total -= $order_total;
                $balance2->avaliable += $order_total;
                $balance2->total += $order_total;
                $balance2->save();
            }
        }
    }

    /**
     * Add a new open order
     * @param  $user_id
     * @param  $market_id
     * @param  $price
     * @param  $amount
     * @param  $type (buy or sell)
     * @return \App\Http\Models\Order
     */
    private function addOrder(Request $request, $response)
    {
        // Only auth users are allowed from here
        if (!Auth::check()) {
            $response['status'] = 'error';
            $response['message'] = 'You can not add order because you are not logged in!.';
            return response()->json($response);
        }

        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->market_id = $request->market_id;
        $order->price = $request->price;
        $order->amount = $request->amount;
        $order->type = $request->type;
        $order->created_at = date('Y-m-d H:i:s');

        // Check balance
        if (($r = $this->canSetOrder($order)) !== true) {
            $response['status'] = 'error';
            $response['message'] = $r;
            return $response;
        }

        // Fill the order(full/partially) or set open order

        // if filled(full/partially) create order history

        // update balance
        $this->updateBalance($order);
        $order->save();

        if ($order->exists) {
            $response['data'] = $order;
            $response['status'] = 'ok';
            $response['message'] = 'Order added.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Sorry order can not be removed.';
        }

        return $response;
    }

    /**
     * Delete given order id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function ajaxAddOrder(Request $request)
    {
        $response = [];
        $invalid_params = false;

        // Filter $request params
        //$request->market_id; // check this is an numeric field, if empty or not numeric set -1
        if ($invalid_params) {
            $response['status'] = 'error';
            $response['message'] = 'Data sended is invalid.';
        } else {
            $response = $this->addOrder($request, $response);
        }

        return response()->json($response);
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

        $order = Order::deleteOrder($request->order_id);

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

        $balances = [];
        $user_orders = [];
        $user_history = [];

        if ($user_id !== null) {
            $balances = Balance::getMarketBalances($user_id, $market_id);

            if ($user_history_last_id !== null) {
                $user_history = OrderHistory::getUserHistory($user_id, $market_id, $user_history_last_id);
            } else {
                $user_history = OrderHistory::getUserHistory($user_id, $market_id);
            }

            if ($user_orders_last_id !== null) {
                $user_orders = Order::getUserOrdersFromLastId($user_id, $market_id, $user_orders_last_id);
            } else {
                $user_orders = Order::getUserOrders($user_id, $market_id);
            }
        }

        $response = [
            'status' => 'ok',
            'message' => '',
            'received' => '',
            'data' => [
                'market_history' => OrderHistory::getMarketHistoryFromLastId($market_id, $market_history_last_id),
                'order_book' => ['buy' => Order::getOrderBook($market_id, 'buy'), 'sell' => Order::getOrderBook($market_id, 'sell')],
                'user_history' => $user_history,
                'user_orders' => $user_orders,
                'balances' => $balances,
            ],
        ];
        return response()->json($response);
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
            $coin = Coin::select('symbol')->where('id', $coin_id)->first();
            $balances[$coin->symbol] = Balance::getBalance($user_id, $coin_id);
        }
        return $balances;
    }

    private function getMarketBalances($user_id, $market_id)
    {
        $market = Market::where('id', $market_id)->first();
        $coin_ids = [$market->traded_coin_id, $market->market_coin_id];
        return $this->getBalances($user_id, $coin_ids);
    }

    public function changeTheme()
    {
        if (Cookie::get('theme') == 'light') {
            Cookie::queue('theme', 'dark', 60 * 24 * 4);
        } else {
            Cookie::queue('theme', 'light', 60 * 24 * 4);
        }

        return redirect(url()->previous());
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
        $coin1 = Coin::findBySymbol($marketGET[0]);
        $coin2 = Coin::findBySymbol($marketGET[1]);

        if ($coin1 === null || $coin2 === null) {
            abort(500, 'Coin not exist.');
        }

        $market = Market::getMarket($coin1->id, $coin2->id);
        if ($market === null) {
            abort(500, 'Market not exist.');
        }

        // Needed settings
        $settings = Setting::all()->keyBy('name');

        // Trade markets (which constains also pairs)
        $markets = Market::getMarkets();

        // User trade history for the actual coin he is trading
        $user_history = OrderHistory::getUserHistory($user_id, $market->id);

        // Open orders from the user
        $user_orders = Order::getUserOrders($user_id, $market->id);

        // User balance
        $balance = $this->getBalances($user_id, [$coin1->id, $coin2->id]);

        // Market history for the actual pair user is trading
        $market_history = OrderHistory::getMarketHistory($market->id);

        $order_book = ['buy' => Order::getOrderBook($market->id, 'buy'), 'sell' => Order::getOrderBook($market->id, 'sell')];

        // Array names
        $names = array('order_book', 'settings', 'market_history', 'markets', 'user_orders', 'user_history', 'pair', 'balance', 'coin1', 'coin2', 'market');
        return view('exchange/trade')->with(compact($names));
    }
}
