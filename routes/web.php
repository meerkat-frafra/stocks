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
Route::get('stocks/zaim', 'StocksController@zaim');

Route::get('stocks/fumi', 'StocksController@fumi');
Route::get('stocks/google', 'StocksController@google');

Route::get('stocks', 'StocksController@index');
// Route::resource('stocks', 'StocksController');

//Route::resource('stocks', 'StocksController');

//  Zaim Api Call Controller
Route::get('/zaim_api/profile', ['as' => 'public.zaim_api.profile', 'uses' => 'ZaimApiController@profile']);
Route::get('/zaim_api/receipt', ['as' => 'public.zaim_api.receipt', 'uses' => 'ZaimApiController@receipt']);
Route::get('/zaim_api/category', ['as' => 'public.zaim_api.category', 'uses' => 'ZaimApiController@category']);
Route::get('/zaim_api/genre', ['as' => 'public.zaim_api.genre', 'uses' => 'ZaimApiController@genre']);
Route::get('/zaim_api', ['as' => 'public.zaim_api', 'uses' => 'ZaimApiController@index']);

// // github
// Route::get('auth/github', 'Auth\LoginController@redirectToProvider');
// Route::get('auth/github/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('auth/{service}', 'Auth\LoginController@redirectToProvider');
Route::get('auth/{service}/callback', 'Auth\LoginController@handleProviderCallback');

// // Zaim
// Route::get('auth/zaim', 'Auth\LoginController@redirectToZaimProvider');
// Route::get('auth/zaim/callback', 'Auth\LoginController@handleZaimProviderCallback');

// Route::get('/homeTimeline', function()
// {
// 	return Twitter::getHomeTimeline(['count' => 20, 'format' => 'json']);
// });

// Route::get('twitter/login', ['as' => 'twitter.login', function(){
// 	// your SIGN IN WITH TWITTER  button should point to this route
// 	$sign_in_twitter = true;
// 	$force_login = false;

// 	// Make sure we make this request w/o tokens, overwrite the default values in case of login.
// 	Twitter::reconfig(['token' => '', 'secret' => '']);
// 	$token = Twitter::getRequestToken(route('twitter.callback'));

// 	if (isset($token['oauth_token_secret']))
// 	{
// 		$url = Twitter::getAuthorizeURL($token, $sign_in_twitter, $force_login);

// 		Session::put('oauth_state', 'start');
// 		Session::put('oauth_request_token', $token['oauth_token']);
// 		Session::put('oauth_request_token_secret', $token['oauth_token_secret']);

// 		return Redirect::to($url);
// 	}

// 	return Redirect::route('twitter.error');
// }]);

// Route::get('twitter/callback', ['as' => 'twitter.callback', function() {
// 	// You should set this route on your Twitter Application settings as the callback
// 	// https://apps.twitter.com/app/YOUR-APP-ID/settings
// 	if (Session::has('oauth_request_token'))
// 	{
// 		$request_token = [
// 			'token'  => Session::get('oauth_request_token'),
// 			'secret' => Session::get('oauth_request_token_secret'),
// 		];

// 		Twitter::reconfig($request_token);

// 		$oauth_verifier = false;

// 		if (Input::has('oauth_verifier'))
// 		{
// 			$oauth_verifier = Input::get('oauth_verifier');
// 			// getAccessToken() will reset the token for you
// 			$token = Twitter::getAccessToken($oauth_verifier);
// 		}

// 		if (!isset($token['oauth_token_secret']))
// 		{
// 			return Redirect::route('twitter.error')->with('flash_error', 'We could not log you in on Twitter.');
// 		}

// 		$credentials = Twitter::getCredentials();

// 		if (is_object($credentials) && !isset($credentials->error))
// 		{
// 			// $credentials contains the Twitter user object with all the info about the user.
// 			// Add here your own user logic, store profiles, create new users on your tables...you name it!
// 			// Typically you'll want to store at least, user id, name and access tokens
// 			// if you want to be able to call the API on behalf of your users.

// 			// This is also the moment to log in your users if you're using Laravel's Auth class
// 			// Auth::login($user) should do the trick.

// 			Session::put('access_token', $token);

// 			return Redirect::to('/')->with('flash_notice', 'Congrats! You\'ve successfully signed in!');
// 		}

// 		return Redirect::route('twitter.error')->with('flash_error', 'Crab! Something went wrong while signing you up!');
// 	}
// }]);

// Card Game
Route::get('game/show/{id}', 'GameController@show');
Route::get('game', 'GameController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
