<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Account\Deposits;
use App\Http\Models\Coins;

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
        //$deposits = Deposits::where('user_id', 1)->get();
        $deposits = Deposits::where('user_id', 1)->paginate(3);

        return view('account/deposits',
        array(
            'deposits' => $deposits,
            'coins' => $coins)
        );
    }
}
