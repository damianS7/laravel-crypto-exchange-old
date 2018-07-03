<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Market;
use App\Http\Models\Coin;
use Collective\Html\Form;

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

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $markets = Market::select('coins.symbol', 'markets.*')
			->join('coins', 'markets.coin_id', '=', 'coins.id')
			->paginate(5);
        return view('admin/markets.index')->with(compact('markets'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //$coins = Coin::all();
        $coins = DB::select('SELECT * FROM coins c WHERE NOT EXISTS (SELECT m.coin_id FROM markets m WHERE c.id = m.coin_id)');
        return view('admin/markets.create')->with(compact('coins'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Http\Models\Coin  $coin
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        try {
            $coin = Coin::findOrFail($request->input('coin_id'));
            $market = new Market;
            $market->coin_id = $coin->id;
            $market->save();
            \Session::flash('success', 'New market created');
        } catch (\Illuminate\Database\QueryException $e) {
            \Session::flash('error', 'Market not added');
        }
        return redirect ('admin/markets');
    }

    /**
    * Display the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function show($marketId)
    {
        $market = Market::select('coins.symbol', 'markets.*')
			->join('coins', 'markets.coin_id', '=', 'coins.id')
            ->where('markets.id', $marketId)->firstOrFail();

        return view('admin/markets.show')->with(compact('market'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function edit($marketId)
    {
        $market = Market::select('coins.symbol', 'markets.*')
			->join('coins', 'markets.coin_id', '=', 'coins.id')
            ->where('markets.id', $marketId)->firstOrFail();

        return view('admin/markets.edit')->with(compact('market'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Http\Models\Market  $market
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Market $market)
    {
        if( $request->submit == 'open_market' ) {
            $market->market_open = 1;
        }

        if( $request->submit == 'close_market' ) {
            $market->market_open = 0;
        }

        try {
            $market->save();
            \Session::flash('success', 'Market updated.');
        } catch (\Illuminate\Database\QueryException $e) {
           \Session::flash('error', 'Market cannot be updated.');
        }

        return redirect ('admin/markets/' . $market->id . '/edit');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Http\Models\Market  $market
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, Market $market)
    {
        if( $request->submit == 'delete' ) {
            try {
                $market->delete();
                \Session::flash('success', 'New market added.');
            } catch (\Illuminate\Database\QueryException $e) {
                \Session::flash('success', 'Market has been deleted.');
            }
        }
        return redirect ('admin/markets');
    }
}