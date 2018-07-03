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

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $coins = Coin::paginate(5);
        return view('admin/coins.index')->with(compact('coins'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('admin/coins.create');
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
            $coin = new Coin;
            $coin->symbol = $request->input('symbol');
            $coin->name = $request->input('name');
            $coin->min_deposit = $request->input('min_deposit');
            $coin->min_withdrawal = $request->input('min_withdrawal');
            $coin->fee_withdrawal = $request->input('fee_withdrawal');
            $coin->save();
            \Session::flash('success', 'New coin created');
        } catch (\Illuminate\Database\QueryException $e) {
            \Session::flash('error', 'Coin not added');
        }
        return redirect ('admin/coins/');
    }

    /**
    * Display the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function show($coinId)
    {
        $coin = Coin::where('id', $coinId)->firstOrFail();
        return view('admin/coins.show')->with(compact('coin'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function edit($coinId)
    {
        $coin = Coin::where('id', $coinId)->firstOrFail();
        return view('admin/coins.edit')->with(compact('coin'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Http\Models\Coin  $coin
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Coin $coin)
    {
        if( $request->submit == 'update' ) {
            $coin->symbol = $request->input('symbol');
            $coin->name = $request->input('name');
            $coin->min_deposit = $request->input('min_deposit');
            $coin->min_withdrawal = $request->input('min_withdrawal');
            $coin->fee_withdrawal = $request->input('fee_withdrawal');

            try {
                $coin->save();
                \Session::flash('success', 'Coin updated.');
            } catch (\Illuminate\Database\QueryException $e) {
                \Session::flash('error', 'Coin cannot be updated.');
            }
        }

        return redirect ('admin/coins/' . $coin->id . '/edit');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Http\Models\Coin  $coin
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, Coin $coin)
    {
        if( $request->submit == 'delete' ) {
            try {
                $coin->delete();
                \Session::flash('success', 'New coin added.');
            } catch (\Illuminate\Database\QueryException $e) {
                \Session::flash('error', 'Coin has been deleted.');
            }
        }
        return redirect ('admin/coins');
    }

}
