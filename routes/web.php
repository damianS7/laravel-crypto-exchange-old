<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});


Route::get('/admin/', function () {
    // if user mail josepwnz == admin
    return view('user/login');
});

// Exchange
Route::redirect('/trade/', '/trade/BTC-USDT', 301);
Route::get('/trade/{pair?}', 'TradeController@index')->name('trade');
Route::get('/trade/', 'TradeController@changeTheme')->name('change-theme');
//Route::get('/trade/{pair?}', function ($pair) {
    // Pasar el pair al controlador para su filtrado
    // Pasar coins markets balances etc a la vista
    //return view('exchange/trade', array('data' => $pair));

//})->name('trade');
//->where('name', '[A-Za-z]+')

// Admin routes
Route::get('/admin/', 'Admin\SettingsController@index')->name('admin');
Route::redirect('/admin/', '/admin/settings/', 301);
Route::get('/admin/accounts', 'Admin\AccountsController@index')->name('admin-accounts');
Route::get('/admin/settings/', 'Admin\SettingsController@index')->name('admin-settings');
Route::post('/admin/settings/', 'Admin\SettingsController@save')->name('admin-save-settings');
Route::get('/admin/coins', 'Admin\CoinsController@index')->name('admin-coins');

Route::get('/admin/pairs', 'Admin\PairsController@index')->name('admin-pairs');
Route::get('/admin/markets', 'Admin\MarketsController@index')->name('admin-markets');
Route::get('/admin/withdrawals', 'Admin\WithdrawalsController@index')->name('admin-withdrawals');

// Account routes
Route::get('/account/', 'Account\OverviewController@index')->name('account');
Route::redirect('/account/', '/account/overview/', 301);
Route::get('/account/overview/', 'Account\OverviewController@index')->name('overview');
Route::get('/account/balances/', 'Account\BalancesController@index')->name('balances');
Route::get('/account/deposits/', 'Account\DepositsController@index')->name('deposits');
Route::get('/account/withdrawals/', 'Account\WithdrawalsController@index')->name('withdrawals');
Route::get('/account/api/', 'Account\ApiController@index')->name('api');
Route::get('/account/verification/', 'Account\VerificationController@index')->name('verification');
Route::get('/account/security/', 'Account\SecurityController@index')->name('security');
Route::get('/account/tradehistory/', 'Account\TradeHistoryController@index')->name('tradehistory');

Route::post('/account/deposits/deposit', 'Account\DepositsController@deposit')->name('deposit');
Route::redirect('/account/deposits/deposit', '/account/deposits/', 301);

// Auth routes
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
