<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\DisasterZone;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/disaster-data', function () {
    return DisasterZone::all();
});


Route::post('update_transaction', ['uses' => 'TransactionController@updateTrasaction']);
Route::post('store_transaction', ['uses' => 'TransactionController@storeTrasaction']);
Route::get('get_transactions', ['uses' => 'TransactionController@getTransactions']);