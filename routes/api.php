<?php

use Illuminate\Http\Request;

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

Route::get('product/list', 'ProductController@get');
Route::get('product/get', 'ProductController@getItem');

Route::get('statistik-transaksi', 'Statistik@transaksi');
Route::get('statistik-pendapatan', 'Statistik@pendapatan');
Route::get('statistik-produk', 'Statistik@produk');

Route::get('order', 'OrderController@list');
Route::get('order-detail', 'PuchaseListController@purchaseList');

Route::get('check', function () {
    return 'OK';
});



