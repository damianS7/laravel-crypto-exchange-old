<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Market;

class MarketsController extends Controller
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
        $markets = Market::paginate(5);
        return view('admin/markets')->with('markets', $markets);
    }
}
