<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Coin;

class CoinsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth-admin');
    }

    public function index()
    {
        $coins = Coin::paginate(5);
        return view('admin/coins')->with('coins', $coins);
    }
}
