<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TradeHistoryController extends Controller
{
    public function index()
    {
        return view('account/tradehistory');
    }
}
