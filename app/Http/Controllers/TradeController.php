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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addOrder(Request $request)
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

        // Balance must be checked before put the order
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->pair_id = $request->pair;
        $order->price = $request->price;
        $order->amount = $request->amount;
        $order->type = $request->type;
        $order->created_at = date('Y-m-d H:i:s');
        $order->save();

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function deleteOrder(Request $request)
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

        $order = Order::find($request->order_id);

        if ($order->delete()) {
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function orderHistory(Request $request)
    {
        $lastId = $request->last_id;
        $pairId = $request->pair_id;

        $orders = OrderHistory::where('pair_id', $pairId)->where('id', '>', $lastId)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->limit('50')->get();

        return response()->json(
            [
                'status' => 'ok',
                'data' => $orders,
            ]
        );

    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function openOrders(Request $request)
    {
        $response = [
            "status" => "error",
            "message" => "You can not fetch orders because you are not logged in!.",
            "data" => "",
        ];

        // Only auth users are allowed from here
        if (!Auth::check()) {
            // Non logged users can't pass
            return response()->json($response);
        }

        $userId = Auth::user()->id;
        $pairId = $request->pair_id;
        $orderId = $request->last_id;
        $orders = Order::where('user_id', $userId)->where('pair_id', $pairId)->where('id', '>', $orderId)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();

        $response['message'] = '';
        $response['status'] = 'ok';
        $response['data'] = $orders;
        return response()->json($response);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filledOrders(Request $request)
    {
        $response = [
            "status" => "error",
            "message" => "You can not fetch orders because you are not logged in!.",
            "data" => "",
        ];

        // Only auth users are allowed from here
        if (!Auth::check()) {
            // Non logged users can't pass
            return response()->json($response);
        }

        $userId = Auth::user()->id;
        $pairId = $request->pair_id;
        $orderId = $request->last_id;

        $orders = OrderHistory::where('user_id', $userId)->where('pair_id', $pairId)->where('id', '>', $orderId)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->get();

        $response['message'] = '';
        $response['status'] = 'ok';
        $response['data'] = $orders;
        return response()->json($response);
    }

    /**
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private function updateBook(Request $request)
    {

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

        $userHistory = array();
        $userOrders = array();

        if (Auth::check()) {
            // User trade history for the actual coin he is trading
            $userHistory = OrderHistory::where('user_id', Auth::user()->id)->where('pair_id', $pair->id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->get();

            // Open orders from the user
            $userOrders = Order::where('user_id', Auth::user()->id)->where('pair_id', $pair->id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->get();

            // User balance
            $balance = $this->updateBalances(Auth::user()->id, $coin1, $coin2);
        }

        // Market history for the actual pair user is trading
        $marketHistory = OrderHistory::where('pair_id', $pair->id)->orderBy('filled_at', 'DESC')->orderBy('id', 'DESC')->limit('50')->get();

        // Book of open orders for the actual pair
        /*
        SELECT oo.price,
        SUM(oo.amount) as 'amount',
        ROUND(SUM(oo.amount)*oo.price, 8) as 'total'
        FROM `open_orders` oo
        WHERE pair_id = 5 AND type='buy'
        GROUP BY price
        ORDER BY price DESC
         */
        $buyOrders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('SUM(price) as "total"'))->where('pair_id', $pair->id)->where('type', 'buy')->groupBy('price')->orderBy('price', 'DESC')->get();

        $sellOrders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('SUM(price) as "total"'))->where('pair_id', $pair->id)->where('type', 'sell')->groupBy('price')->orderBy('price', 'DESC')->get();

        //$bookOrder = array('buys' => $buyOrders, 'sells' => $sellOrders);

        // Array names
        $names = array('settings', 'marketHistory', 'markets', 'userOrders', 'userHistory', 'pair', 'sellOrders', 'buyOrders', 'balance', 'coin1', 'coin2');

        return view('exchange/trade')->with(compact($names));
    }

}
