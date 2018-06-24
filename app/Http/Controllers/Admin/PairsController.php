<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Pair;
use App\Http\Models\Coin;
use App\Http\Models\Market;

class PairsController extends Controller
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
        //$pairs = DB::select('SELECT coins.symbol, (SELECT coins.symbol FROM markets INNER JOIN coins ON coins.id = markets.coin_id WHERE markets.coin_id = pp.market_id) as "market", pp.* FROM pairs pp INNER JOIN coins ON coins.id = pp.coin_id');

        $pairs = Pair::select('coins.symbol', DB::raw('(SELECT coins.symbol FROM markets INNER JOIN coins ON coins.id = markets.coin_id WHERE markets.coin_id = pp.market_id) as "market"'), 'pp.*')->from('pairs as pp')->join('coins', 'coins.id', '=', 'pp.coin_id')->paginate(5);

        return view('admin/pairs.index')->with(compact('pairs'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $coins = Coin::all();
        $markets = Market::select('coins.symbol', 'markets.*')
			->join('coins', 'markets.coin_id', '=', 'coins.id')
			->get();
        return view('admin/pairs.create')->with(compact('coins', 'markets'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Http\Models\Pair  $pair
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        // check if coin1 and market are the same
        if($request->input('coin_id') == $request->input('market_id')) {
            \Session::flash('error', 'Coin and market cannot be the same');
            return redirect ('admin/pairs');
        }

        try {
            $pair = new Pair;
            $pair->coin_id = $request->input('coin_id');
            $pair->market_id = $request->input('market_id');
            $pair->save();
            \Session::flash('success', 'New pair created');
        } catch (\Illuminate\Database\QueryException $e) {
            \Session::flash('error', 'Pair not added');
        }
        return redirect ('admin/pairs');
    }

    /**
    * Display the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function show($pairId)
    {
        $pair = Pair::select('coins.symbol', 'markets.*')
			->join('coins', 'markets.coin_id', '=', 'coins.id')
            ->where('markets.id', $marketId)->firstOrFail();

        return view('admin/pairs.show')->with(compact('pair'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function edit($pairId)
    {
        $pair = Pair::select('coins.symbol', DB::raw('(SELECT coins.symbol FROM markets INNER JOIN coins ON coins.id = markets.coin_id WHERE markets.coin_id = pp.market_id) as "market"'), 'pp.*')->from('pairs as pp')->join('coins', 'coins.id', '=', 'pp.coin_id')->where('pp.id', $pairId)->first();

        return view('admin/pairs.edit')->with(compact('pair'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Http\Models\Pair  $pair
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Pair $pair)
    {
        if( $request->submit == 'resume_pair' ) {
            $pair->tradeable = 1;
        }

        if( $request->submit == 'suspend_pair' ) {
            $pair->tradeable = 0;
        }

        try {
            $pair->save();
            \Session::flash('success', 'Pair updated.');
        } catch (\Illuminate\Database\QueryException $e) {
           \Session::flash('error', 'Pair cannot be updated.');
        }

        return redirect ('admin/pairs/' . $pair->id . '/edit');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Http\Models\Pair  $pair
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, Pair $pair)
    {
        if( $request->submit == 'delete' ) {
            $pair->delete();
        }

        \Session::flash('success', 'Pair deleted');
        return redirect ('admin/pairs');
    }
}
