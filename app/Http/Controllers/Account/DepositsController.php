<?php

namespace App\Http\Controllers\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Deposit;
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
        $coins = Coin::all();
        $userId = Auth::user()->id;
        //$deposits = Deposits::where('user_id', 1)->get();
        $deposits = Deposit::where('user_id', $userId)->paginate(3);

        return view('account/deposits',
        array(
            'deposits' => $deposits,
            'coins' => $coins)
        );
    }
}
