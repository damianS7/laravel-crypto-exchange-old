<?php

namespace App\Http\Controllers\Trading;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PairController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pair)
    {
        // check if pair exists
        return view('exchange/trade', array('data' => $pair));
    }
}
