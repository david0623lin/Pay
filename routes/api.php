<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// 商戶
Route::group(['namespace' => 'Trade', 'prefix' => 'trade'], function(){
    Route::post('pay', 'OrderController@pay');
    Route::post('pay/pepay', 'OrderController@receive01');
    Route::get('pay/pepay', 'OrderController@receive02');
});
