<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Withdrawal;

class WithdrawalsController extends Controller
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
        $withdrawals = Withdrawal::paginate(5);
        return view('admin/withdrawals')->with('withdrawals', $withdrawals);
    }
}
