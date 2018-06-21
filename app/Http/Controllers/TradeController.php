<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Setting;
use App\Http\Models\Market;
use App\Http\Models\Order;
use App\Http\Models\Pair;

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

		return redirect ('trade');
	}

	private function pairExists() {
		//$search = Pair::find();
		//if exists return true else false
	}


	public function index()
	{
		// Check if cookie theme is set
		if( empty(Cookie::get('theme')) ) {
			// set cookie for color theme
			Cookie::queue('theme', 'light', 60*24*4);
		}

		// Check the trading pair selected
		// redirect if not exists
		// return redirect()

		// Needed settings
		$settings = Setting::all()->keyBy('name');

		// Trade markets (which constains also pairs)
		$markets = Market::select('markets.*', 'coins.symbol')
			->join('coins', 'markets.coin_id', '=', 'coins.id')
			->get()->keyBy('symbol');

		// User trade history for the actual coin he is trading
		$userHistory = Setting::all();

		// Market history for the actual pair user is trading
		$marketHistory = Setting::all();

		// Book of open orders for the actual pair
		$bookOrder = Order::all();

		// Array names
		$names = array('settings', 'bookOrder', 'marketHistory', 'markets', 'userHistory');

		return view('exchange/trade')->with(compact($names));
	}

}
