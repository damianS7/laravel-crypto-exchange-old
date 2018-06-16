<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Pair;

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

    public function index()
    {
        $pairs = Pair::paginate(5);
        return view('admin/pairs')->with('pairs', $pairs);
    }
}
