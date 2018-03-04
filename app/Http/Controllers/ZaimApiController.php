<?php

namespace App\Http\Controllers;

//ini_set('display_errors', "On");
//ini_set('include_path', '.:/app/.heroku/php/lib/php:/app/library');

//require_once('HTTP/OAuth/Consumer.php');

use DB;
use Request;
use Log;
use Stock;
use Lib

class ZaimApiController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

		// Provider info
		$provider_base = 'https://api.zaim.net/v2/auth/';
		$request_url = $provider_base.'request';
		$authorize_url = 'https://auth.zaim.net/users/auth';
		$access_url = $provider_base.'access';
		$resource_url = 'https://api.zaim.net/v2/home/user/verify';
		$shopping_url = 'https://api.zaim.net/v2/home/money';

		// Consumer info
		$consumer_key = '451ea73a551f5ef81bbe7680bf8eeb8fb5056c6a';
		$consumer_secret = '2a44b1a5be33ee3e80cbfeee4e7ed9810cd9597b';
		$callback_url = sprintf('http://%s%s', $_SERVER['HTTP_HOST'], $_SERVER['SCRIPT_NAME']);

		$content = '';
		try {
  			// Initialize HTTP_OAuth_Consumer
			$oauth = new Lib\HTTP_OAuth_Consumer($consumer_key, $consumer_secret);
 
			// Enable SSL
			$http_request = new Lib\HTTP_Request2();
			$http_request->setConfig('ssl_verify_peer', false);
			$consumer_request = new Lib\HTTP_OAuth_Consumer_Request;
			$consumer_request->accept($http_request);
			$oauth->accept($consumer_request);
  
			if (!$request->session()->exists('type')) $request->session()->put('type', null);
  
  			// 2 Authorize
			if ($request->session()->get('type')=='authorize') {
				// Exchange the Request Token for an Access Token
				$oauth->setToken($request->session()->get('oauth_token'));
				$oauth->setTokenSecret($request->session()->get('oauth_token_secret'));
				$oauth->getAccessToken($access_url, $request->input('oauth_verifier'));
 
				// Save an Access Token
				$request->session()->put('type', 'access');
				$request->session()->put('oauth_token', $oauth->getToken());
				$request->session()->put('oauth_token_secret', $oauth->getTokenSecret());
			}
 
  			// 3 Access
			if ($request->session()->get('type')=='access') {
				// Accessing Protected Resources
				$oauth->setToken($request->session()->get('oauth_token'));
				$oauth->setTokenSecret($request->session()->get('oauth_token_secret'));
				$result = $oauth->sendRequest($resource_url, array(), 'GET');
				$content = $result->getBody();

				$result2 = $oauth->sendRequest('https://api.zaim.net/v2/home/money', array(), 'GET');
				$content2 = $result2->getBody();

				dd($content,$content2);

				// 1 Request
			} else {
				// Get a Request Token
				$oauth->getRequestToken($request_url, $callback_url);
 
				// Save a Request Token
				$request->session()->put('type', 'authorize');
				$request->session()->put('oauth_token', $oauth->getToken());
				$request->session()->put('oauth_token_secret', $oauth->getTokenSecret());
 
				// Get an Authorize URL
				$authorize_url = $oauth->getAuthorizeURL($authorize_url);
				
				dd($authorize_url);

			}
 
		} catch (Exception $e) {
			Log::error($e->getMessage());
		}

	}

}
