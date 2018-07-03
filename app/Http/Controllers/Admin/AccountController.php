<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Account;

class AccountsController extends Controller
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
        $accounts = Account::paginate(2);
        return view('admin/accounts.index')->with(compact('accounts'));
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
    public function show($accountId)
    {
        $account = Account::where('id', $accountId)->firstOrFail();
        return view('admin/accounts.show')->with(compact('account'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function edit($accountId)
    {
        $account = Account::where('id', $accountId)->firstOrFail();
        return view('admin/accounts.edit')->with(compact('account'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Http\Models\Account  $account
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Account $account)
    {
        if( $request->submit == 'update' ) {
            $account->email = $request->input('email');
            $account->privileges = $request->input('privileges');
            \Session::flash('success', 'Account updated.');
        }
        
        if( $request->submit == 'freeze' ) {
        }
        
        if( $request->submit == 'password') {
            $pass = str_random(6);
            $account->password = bcrypt($pass);
            \Session::flash('success', 'New password: ' . $pass);
        }

        try {
            $account->save();
        } catch (\Illuminate\Database\QueryException $e) {
            \Session::flash('error', 'Account cannot be updated.');
        }
        return redirect ('admin/accounts/' . $account->id . '/edit');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Http\Models\Account  $account
    * @return \Illuminate\Http\Response
    */
    public function destroy(Request $request, Account $account)
    {
        if( $request->submit == 'delete' ) {
            try {
                $account->delete();
                \Session::flash('success', 'Account deleted.');
            } catch (\Illuminate\Database\QueryException $e) {
                \Session::flash('error', 'Account cannot be deleted.');
            }
        }
        return redirect ('admin/accounts');
    }

}
