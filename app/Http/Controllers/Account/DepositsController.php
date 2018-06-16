<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Account\Deposit;
use App\Http\Models\Coin;

class DepositsController extends Controller
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

    private function assignAddress() {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deposit() {
        //return 'deposit ' . $_POST['coin'];

        $this->index();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins = Coins::all();
        $id = 1;
        //$deposits = Deposits::where('user_id', 1)->get();
        $deposits = Deposit::where('user_id', $id)->paginate(3);

        return view('account/deposits',
        array(
            'deposits' => $deposits,
            'coins' => $coins)
        );
    }
}
