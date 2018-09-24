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

Route::get('stocks/new/space/{space}', 'StocksController@space');
Route::get('stocks/new', 'StocksController@newindex');

Route::get('stocks/zaim/import/{id}', 'StocksController@zaimImport');
Route::get('stocks/zaim/delete/{id}', 'StocksController@zaimDelete');
Route::get('stocks/zaim', 'StocksController@zaim');

Route::get('stocks/fumi', 'StocksController@fumi');
Route::get('stocks/google', 'StocksController@google');

Route::get('stocks', 'StocksController@index');

//  Zaim Api Call Controller
Route::get('/zaim_api/profile', ['as' => 'public.zaim_api.profile', 'uses' => 'ZaimApiController@profile']);
Route::get('/zaim_api/receipt', ['as' => 'public.zaim_api.receipt', 'uses' => 'ZaimApiController@receipt']);
Route::get('/zaim_api/category', ['as' => 'public.zaim_api.category', 'uses' => 'ZaimApiController@category']);
Route::get('/zaim_api/genre', ['as' => 'public.zaim_api.genre', 'uses' => 'ZaimApiController@genre']);
Route::get('/zaim_api/clear', ['as' => 'public.zaim_api.clear', 'uses' => 'ZaimApiController@clear']);
Route::get('/zaim_api', ['as' => 'public.zaim_api', 'uses' => 'ZaimApiController@index']);

// // github
// Route::get('auth/github', 'Auth\LoginController@redirectToProvider');
// Route::get('auth/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('auth/{service}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{service}/callback', 'Auth\LoginController@handleProviderCallback');

// Card Game
Route::get('game/trash/{card}', 'GameController@trash');
Route::get('game/pull/{card}', 'GameController@pull');
Route::get('game/room', 'GameController@room');
Route::get('game/entry/{id}', 'GameController@entry');
Route::get('game/entryin', 'GameController@entryIn');
Route::get('game/', 'GameController@');
Route::get('game/show/{id?}', 'GameController@show');
Route::get('game', 'GameController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
