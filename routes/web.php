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
    return view('welcome');
});


Route::get('stocks/create', 'StocksController@create');
Route::post('stocks/store', 'StocksController@store');
Route::get('stocks/edit/{id}', 'StocksController@edit');
Route::post('stocks/update', 'StocksController@update');
Route::get('stocks/destroy/{id}', 'StocksController@destroy');
Route::get('stocks/history', 'StocksController@history');
Route::get('stocks/usage/{type}/{id}', 'StocksController@usage');
Route::get('stocks/gotit/{id}', 'StocksController@gotit');
Route::get('stocks', 'StocksController@index');
// Route::resource('stocks', 'StocksController');

//Route::resource('stocks', 'StocksController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
