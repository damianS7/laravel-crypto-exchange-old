<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Models\Setting;

class SettingsController extends Controller
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

    public function save(Request $request) {

        // Update record on database
        foreach ($request->input() as $name => $value) {

            try {
                //$settings = Setting::findOrFail($name);
                $settings = Setting::where('name', '=', $name)->firstOrFail();
                $settings->value = $value;
                $settings->save();
                \Session::flash('success', 'Successfully updated!');
            }catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                //\Session::flash('info', 'Some fields where not saved. (Incorrect id)');
            }

        }

        return redirect ('admin/settings');
    }

    public function index()
    {
        $settings = Setting::all()->keyBy('name');
        return view('admin/settings')->with('settings', $settings);
    }
}
