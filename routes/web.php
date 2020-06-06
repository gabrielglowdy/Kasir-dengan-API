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
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // Only authenticated users may enter...
    Route::get('/', function () {
        return view('home');
    });



    Route::get('/home', 'HomeController@index');

    //Kategori
    Route::get('/category/list', 'CategoryController@daftar');
    Route::get('/category/new', 'CategoryController@showTambah');
    Route::post('/category/new', 'CategoryController@tambah');
    Route::post('/category/delete/{id}', 'CategoryController@delete');
    Route::get('/category/edit/{id}', 'CategoryController@showEdit');
    Route::post('/category/edit/{id}', 'CategoryController@edit');

    //Produk
    Route::get('/product/list', 'ProductController@daftarProduk');
    Route::get('/product/new', 'ProductController@showTambah');
    Route::post('/product/new', 'ProductController@tambah');
    Route::get('/product/edit/{id}', 'ProductController@showEdit');
    Route::post('/product/edit/{id}', 'ProductController@edit');
    Route::post('/product/delete/{id}', 'ProductController@delete');

    //Order
    Route::get('/order/new', 'OrderController@newOrder');
    Route::post('/order/ordering', 'OrderController@ordering');
    Route::post('/order/pay', 'OrderController@pay');
    Route::get('/order/change', 'OrderController@finish');


    // Transaction
    Route::get('/transaction/list', 'Pages@history');
    Route::get('/transaction/detail/{id}', 'Pages@historyPurchase');

    //Statistik
    Route::get('/statistic', 'Pages@statistik');
});
