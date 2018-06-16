<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalsController extends Controller
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

        // List of avaliable coins to filter withdrawals

        // if post coin filter
        //$coin = xxx
        //$withdrawals = Withdrawal::where('user_id', $userId)
        //->where('coin_id', $coinId)->paginate(3);
        //inner join on coind id = id on coins
        //else
        $withdrawals = Withdrawal::where('user_id', $userId)->paginate(3);
        return view('account/withdrawals')->with('Withdrawals', $withdrawals);
    }
}
