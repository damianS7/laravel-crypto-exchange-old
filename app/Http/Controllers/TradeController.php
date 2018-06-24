<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Models\OrderHistory;
use App\Http\Models\Setting;
use App\Http\Models\Market;
use App\Http\Models\Order;
use App\Http\Models\Pair;
use App\Http\Models\Coin;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{

	public function addOrder() {

	}

	public function cancelOrder() {

	}

	public function changeTheme() {
		if(Cookie::get('theme') == 'light') {
			Cookie::queue('theme', 'dark', 60*24*4);
		} else {
			Cookie::queue('theme', 'light', 60*24*4);
		}
		//return redirect ('trade');
		return redirect (url()->previous());
	}

	private function pairExists() {
		//$search = Pair::find();
		//if exists return true else false
	}


	public function index(Request $request, $pair = NULL)
	{
		// Check if cookie theme is set
		if( empty(Cookie::get('theme')) ) {
			// set cookie for color theme
			Cookie::queue('theme', 'light', 60*24*4);
		}

		// Get the coin pair symbols
		$coinsPair = explode('-', $pair);

		// Get id from each coin
		// Also firstOrFail will throw 'page dont exist' message in user browser if not founded in db
		$coin1 = Coin::where('symbol', $coinsPair[0])->firstOrFail();
		$coin2 = Coin::where('symbol', $coinsPair[1])->firstOrFail();
		$marketPair = Market::where('coin_id', $coin2->id)->firstOrFail();
		$tradingPair = Pair::where('coin_id', $coin1->id)->where('market_id', $marketPair->id)->firstOrFail();

		// Needed settings
		$settings = Setting::all()->keyBy('name');

		// Trade markets (which constains also pairs)
		$markets = Market::select('markets.*', 'coins.symbol')
			->join('coins', 'markets.coin_id', '=', 'coins.id')
			->get()->keyBy('symbol');

		// If user is logged we will fetch their trade history in this pair
		if (Auth::check())
		{
			// User trade history for the actual coin he is trading
			$userHistory = OrderHistory::where('user_id', Auth::user()->id)
				->where('pair_id', $tradingPair->id)->get();
		} else {
			$userHistory = array();
		}

		// Market history for the actual pair user is trading
		$marketHistory = OrderHistory::where('pair_id', $tradingPair->id)->get();

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
		$buyOrders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('SUM(price) as "total"'))->where('pair_id', $tradingPair->id)->where('type', 'buy')->groupBy('price')->orderBy('price', 'DESC')->get();


		$sellOrders = Order::select('price', DB::raw('SUM(amount) as "amount"'), DB::raw('SUM(price) as "total"'))->where('pair_id', $tradingPair->id)->where('type', 'sell')->groupBy('price')->orderBy('price', 'DESC')->get();

		//$bookOrder = array('buys' => $buyOrders, 'sells' => $sellOrders);

		// Array names
		$names = array('settings', 'marketHistory', 'markets', 'userHistory', 'pair', 'sellOrders', 'buyOrders');

		return view('exchange/trade')->with(compact($names));
	}

}
