<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/update', '\App\Http\Controllers\DashboardController@do_update')->name('do_update');
Route::get('/get_update', '\App\Http\Controllers\DashboardController@get_update')->name('get_update');
Route::get('/get_update/success', '\App\Http\Controllers\DashboardController@get_update_success')->name('get_update_success');


