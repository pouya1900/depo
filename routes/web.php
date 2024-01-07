<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', '\App\Http\Controllers\DashboardController@home')->name('index');
Route::get('/dashboard', '\App\Http\Controllers\DashboardController@dashboard')->name('dashboard');
Route::get('/update', '\App\Http\Controllers\DashboardController@update')->name('update');

Route::get('/users', '\App\Http\Controllers\UserController@index')->name('users');
Route::get('/users/create', '\App\Http\Controllers\UserController@create')->name('create_user');
Route::post('/users/store', '\App\Http\Controllers\UserController@store')->name('store_user');
Route::get('/users/edit/{user}', '\App\Http\Controllers\UserController@edit')->name('edit_user');
Route::post('/users/update/{user}', '\App\Http\Controllers\UserController@update')->name('update_user');

Route::get('/sands', '\App\Http\Controllers\SandController@index')->name('sands');
Route::get('/sands/create', '\App\Http\Controllers\SandController@create')->name('create_sand');
Route::post('/sands/store', '\App\Http\Controllers\SandController@store')->name('store_sand');
Route::get('/sands/edit/{sand}', '\App\Http\Controllers\SandController@edit')->name('edit_sand');
Route::post('/sands/update/{sand}', '\App\Http\Controllers\SandController@update')->name('update_sand');

Route::get('/mines', '\App\Http\Controllers\MineController@index')->name('mines');
Route::get('/mines/create', '\App\Http\Controllers\MineController@create')->name('create_mine');
Route::post('/mines/store', '\App\Http\Controllers\MineController@store')->name('store_mine');
Route::get('/mines/edit/{mine}', '\App\Http\Controllers\MineController@edit')->name('edit_mine');
Route::post('/mines/update/{mine}', '\App\Http\Controllers\MineController@update')->name('update_mine');

Route::get('/sells', '\App\Http\Controllers\SellController@index')->name('sells');
Route::get('/sells/complete/{sell}', '\App\Http\Controllers\SellController@complete_sell')->name('complete_sell');
Route::get('/sells/create', '\App\Http\Controllers\SellController@create')->name('create_sell');
Route::post('/sells/store', '\App\Http\Controllers\SellController@store')->name('store_sell');
Route::get('/sells/edit/{sell}', '\App\Http\Controllers\SellController@edit')->name('edit_sell');
Route::post('/sells/update/{sell}', '\App\Http\Controllers\SellController@update')->name('update_sell');
Route::get('/sells/delete/{sell}', '\App\Http\Controllers\SellController@delete')->name('delete_sell');

Route::get('/buys', '\App\Http\Controllers\BuyController@index')->name('buys');
Route::get('/buys/create', '\App\Http\Controllers\BuyController@create')->name('create_buy');
Route::post('/buys/store', '\App\Http\Controllers\BuyController@store')->name('store_buy');
Route::get('/buys/edit/{buy}', '\App\Http\Controllers\BuyController@edit')->name('edit_buy');
Route::post('/buys/update/{buy}', '\App\Http\Controllers\BuyController@update')->name('update_buy');
Route::get('/buys/delete/{buy}', '\App\Http\Controllers\BuyController@delete')->name('delete_buy');

Route::get('/checks', '\App\Http\Controllers\CheckController@index')->name('checks');
Route::get('/checks/create', '\App\Http\Controllers\CheckController@create')->name('create_check');
Route::post('/checks/store', '\App\Http\Controllers\CheckController@store')->name('store_check');
Route::get('/checks/edit/{check}', '\App\Http\Controllers\CheckController@edit')->name('edit_check');
Route::post('/checks/update/{check}', '\App\Http\Controllers\CheckController@update')->name('update_check');
Route::get('/checks/delete/{check}', '\App\Http\Controllers\CheckController@delete')->name('delete_check');

Route::get('/checks/send', '\App\Http\Controllers\SendCheckController@index')->name('send_checks');
Route::get('/checks/send/create', '\App\Http\Controllers\SendCheckController@create')->name('create_send_check');
Route::post('/checks/send/store', '\App\Http\Controllers\SendCheckController@store')->name('store_send_check');
Route::get('/checks/send/edit/{check}', '\App\Http\Controllers\SendCheckController@edit')->name('edit_send_check');
Route::post('/checks/send/update/{check}', '\App\Http\Controllers\SendCheckController@update')->name('update_send_check');
Route::get('/checks/send/delete/{check}', '\App\Http\Controllers\SendCheckController@delete')->name('delete_send_check');

Route::get('/deposits', '\App\Http\Controllers\DepositController@index')->name('deposits');
Route::get('/deposits/create', '\App\Http\Controllers\DepositController@create')->name('create_deposit');
Route::post('/deposits/store', '\App\Http\Controllers\DepositController@store')->name('store_deposit');
Route::get('/deposits/edit/{deposit}', '\App\Http\Controllers\DepositController@edit')->name('edit_deposit');
Route::post('/deposits/update/{deposit}', '\App\Http\Controllers\DepositController@update')->name('update_deposit');
Route::get('/deposits/delete/{deposit}', '\App\Http\Controllers\DepositController@delete')->name('delete_deposit');

Route::get('/members', '\App\Http\Controllers\MemberController@index')->name('members');
Route::get('/members/create', '\App\Http\Controllers\MemberController@create')->name('create_member');
Route::post('/members/store', '\App\Http\Controllers\MemberController@store')->name('store_member');
Route::get('/members/edit/{member}', '\App\Http\Controllers\MemberController@edit')->name('edit_member');
Route::post('/members/update/{member}', '\App\Http\Controllers\MemberController@update')->name('update_member');
Route::get('/members/delete/{member}', '\App\Http\Controllers\MemberController@delete')->name('delete_member');
Route::get('/members/show/{member}', '\App\Http\Controllers\MemberController@show')->name('show_member');

