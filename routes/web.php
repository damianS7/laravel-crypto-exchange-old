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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');

// Exchange
Route::post('/trade/ajax/order/add', 'TradeController@ajaxAddOrder');
Route::post('/trade/ajax/order/delete', 'TradeController@ajaxDeleteOrder');
Route::get('/trade/ajax/update', 'TradeController@ajaxUpdateView');

Route::get('/trade/theme{theme?}', 'TradeController@changeTheme')->name('change-theme');
Route::redirect('/trade/', '/trade/BTC-USDT', 302);
Route::get('/trade/{market?}', 'TradeController@index')->name('trade');

// Admin routes
Route::get('/admin/', 'Admin\SettingsController@index')->name('admin');
Route::redirect('/admin/', '/admin/settings/', 302);
Route::get('/admin/settings/', 'Admin\SettingsController@index')->name('admin-settings');
Route::post('/admin/settings/', 'Admin\SettingsController@save')->name('admin-save-settings');
Route::resource('/admin/accounts', 'Admin\AccountsController');
Route::resource('/admin/pairs', 'Admin\PairsController');
Route::resource('/admin/coins', 'Admin\CoinsController');
Route::resource('/admin/markets', 'Admin\MarketsController');
Route::get('/admin/withdrawals', 'Admin\WithdrawalsController@index')->name('admin-withdrawals');

// Account routes
Route::get('/account/', 'Account\OverviewController@index')->name('account');
Route::redirect('/account/', '/account/overview/', 302);
Route::get('/account/overview/', 'Account\OverviewController@index')->name('overview');
Route::get('/account/balances/', 'Account\BalancesController@index')->name('balances');
Route::get('/account/deposits/', 'Account\DepositsController@index')->name('deposits');
Route::get('/account/withdrawals/', 'Account\WithdrawalsController@index')->name('withdrawals');
Route::get('/account/api/', 'Account\ApiController@index')->name('api');
Route::get('/account/verification/', 'Account\VerificationController@index')->name('verification');
Route::get('/account/security/', 'Account\SecurityController@index')->name('security');
Route::get('/account/tradehistory/', 'Account\TradeHistoryController@index')->name('tradehistory');
Route::post('/account/deposits/deposit', 'Account\DepositsController@deposit')->name('deposit');
Route::redirect('/account/deposits/deposit', '/account/deposits/', 302);

// Auth routes
Auth::routes();
