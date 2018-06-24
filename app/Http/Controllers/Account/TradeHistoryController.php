<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\OrderHistory;

class TradeHistoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::user()->id;
        // Select coin symbols
        //$tradeHistory = OrderHistory::select('')->where('user_id', $userId)->paginate(2);
        //SELECT pairs.id as 'pair_id', coins.symbol as 'coin',
        //(SELECT coins.symbol as 'coin'
        //FROM markets INNER JOIN coins ON coins.id = markets.coin_id WHERE markets.id = pairs.market_id) as 'market'
        //FROM pairs INNER JOIN coins ON coins.id = pairs.coin_id

        $tradeHistory = OrderHistory::where('user_id', $userId)->paginate(2);
        return view('account/tradehistory', array('tradeHistory' => $tradeHistory) );
    }
}
