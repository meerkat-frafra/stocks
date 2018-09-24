<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Log;
use Stock;
use HTTP_OAuth_Consumer;
use HTTP_Request2;
use HTTP_OAuth_Consumer_Request;

class ZaimApiController extends Controller
{

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    // Provider info
		$this->provider_base = 'https://api.zaim.net/v2/auth/';
		$this->request_url   = $this->provider_base.'request';
		$this->authorize_url = 'https://auth.zaim.net/users/auth';
		$this->access_url    = $this->provider_base.'access';
		$this->resource_url  = 'https://api.zaim.net/v2/home/user/verify';
		$this->shopping_url  = 'https://api.zaim.net/v2/home/money';
    $this->category_url  = 'https://api.zaim.net/v2/home/category';
    $this->genre_url     = 'https://api.zaim.net/v2/home/genre';

		// Consumer info
		$this->consumer_key    = '451ea73a551f5ef81bbe7680bf8eeb8fb5056c6a';
		$this->consumer_secret = '2a44b1a5be33ee3e80cbfeee4e7ed9810cd9597b';
    $this->callback_url    = sprintf('http://%s%s', $_SERVER['HTTP_HOST'], '/zaim_api');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

		$content = '';
		try {
  		// Initialize HTTP_OAuth_Consumer
      $oauth = self::_oauth();

			if ($request->session()->has('type')) {
      
        if ($request->session()->get('type')=='authorize') {
          // Exchange the Request Token for an Access Token
          $oauth->setToken($request->session()->get('oauth_token'));
          $oauth->setTokenSecret($request->session()->get('oauth_token_secret'));
          $oauth->getAccessToken($this->access_url, $request->input('oauth_verifier'));

          // Save an Access Token
          $request->session()->put('type', null);
          $request->session()->put('oauth_token', $oauth->getToken());
          $request->session()->put('oauth_token_secret', $oauth->getTokenSecret());

          $input = [
            'oauth_token'        => $oauth->getToken(),
            'oauth_token_secret' => $oauth->getTokenSecret(),
          ];
          DB::table('zaims')->where('user_id', 1)->update($input);
        }
      }

      $token = DB::table('zaims')->where('user_id', 1)->where('updated_at', '>=', date('Y-m-d H:i:s', strtotime('-1 day')))->first();
      if (!empty($token)) {
        // 認証済み
      } else {
        // Zaim認証

        // Get a Request Token
        $oauth->getRequestToken($this->request_url, $this->callback_url);

        // insert zaims table.
        $input = ['user_id'            => 1,
                  'consumer_key'       => $this->consumer_key,
                  'consumer_secret'    => $this->consumer_secret,
                  'oauth_token'        => $oauth->getToken(),
                  'oauth_token_secret' => $oauth->getTokenSecret(),
                  'profile_image_url'  => '',
                  'name'               => '',
                  'zaim_user_id'       => '',
                  'user_info'          => '',
                  'updated_at' => date('Y-m-d H:i:s'),
                  ];
        DB::table('zaims')->where('user_id', 1)->delete(); 
        DB::table('zaims')->insert($input);

        // Save a Request Token
        $request->session()->put('type', 'authorize');
        $request->session()->put('oauth_token', $oauth->getToken());
        $request->session()->put('oauth_token_secret', $oauth->getTokenSecret());

        // Get an Authorize URL
        $authorize_url = $oauth->getAuthorizeURL($this->authorize_url);
        return redirect()->away($authorize_url);
      }
      Log::info('Zaimアカウントの認証を行いました');
      echo 'Zaimアカウントの認証を行いました';
		} catch (Exception $e) {
			Log::error($e->getMessage());
		}
	}

  /**
   *  プロフィール情報取得
   *
   * @return \Illuminate\Http\Response
   */
  public function profile(Request $request)
  {
    $token = DB::table('zaims')->where('user_id', 1)->first();
    if (empty($token)) return redirect('zaim_api');

    $content = '';
    try {
      // OAuth 認証
      $oauth = self::_oauth();
      // Zaim Api 呼び出し
      $content = self::_call($this->resource_url, $oauth, $request);

      // update zaims table.
      $zaimUserInfo = json_decode($content, true);

      $input = [
        'name'              => $zaimUserInfo['me']['name'],
        'profile_image_url' => $zaimUserInfo['me']['profile_image_url'],
        'zaim_user_id'      => $zaimUserInfo['me']['id'],
        'user_info'         => serialize($zaimUserInfo['me']),
      ];
      DB::table('zaims')->where('user_id', 1)->update($input);

      Log::info('ZaimApiからプロフィール情報を取得しました');

    } catch (Exception $e) {
      Log::error($e->getMessage());
    }
  }

  /**
   * レシート情報取得
   *
   * @return \Illuminate\Http\Response
   */
  public function receipt(Request $request)
  {
    $token = DB::table('zaims')->where('user_id', 1)->first();
    if (empty($token)) return redirect('zaim_api');

    $content = '';
    try {
      // OAuth 認証
      $oauth = self::_oauth();
      // Zaim Api 呼び出し
      $content = self::_call($this->shopping_url, $oauth, $request);

      $zaimShoppingInfo = json_decode($content, true);

      if (empty($zaimShoppingInfo['money'])) exit;

      $cnt = 0;
      foreach ($zaimShoppingInfo['money'] as $c) {
        if (DB::table('zaim_records')->where('zaim_id', $c['id'])->count() == 0) {
          $input = [
            'zaim_id'         => $c['id'],
            'zaim_user_id'    => $c['user_id'],
            'date'            => $c['date'],
            'mode'            => $c['mode'],
            'category_id'     => $c['category_id'],
            'genre_id'        => $c['genre_id'],
            'from_account_id' => $c['from_account_id'],
            'to_account_id'   => $c['to_account_id'],
            'amount'          => $c['amount'],
            'comment'         => $c['comment'],
            'active'          => $c['active'],
            'created'         => $c['created'],
            'currency_code'   => $c['currency_code'],
            'name'            => $c['name'],
            'receipt_id'      => $c['receipt_id'],
            'place_uid'       => $c['place_uid'],
            'place'           => $c['place'],
          ];
          DB::table('zaim_records')->insert($input);
          $cnt++;
        }
      }
      echo $cnt;
      Log::info('ZaimApiからレシート情報を取得しました');
      exit;
    } catch (Exception $e) {
      Log::error($e->getMessage());
    }
  }

  /**
   * カテゴリ情報取得
   *
   * @return \Illuminate\Http\Response
   */
  public function category(Request $request)
  {
    $token = DB::table('zaims')->where('user_id', 1)->first();
    if (empty($token)) return redirect('zaim_api');

    $content = '';
    try {
      // OAuth 認証
      $oauth = self::_oauth();
      // Zaim Api 呼び出し
      $content = self::_call($this->category_url, $oauth, $request);

      $conArr = json_decode($content, true);

      if (empty($conArr['categories'])) exit;

      DB::table('zaim_categories')->delete();
      foreach ($conArr['categories'] as $c) {
        $input = [
          'category_id'        => $c['id'],
          'name'               => $c['name'],
          'mode'               => $c['mode'],
          'sort'               => $c['sort'],
          'parent_category_id' => $c['parent_category_id'],
          'active'             => $c['active'],
          'modified'           => $c['modified'],
        ];
        DB::table('zaim_categories')->insert($input);
      }
      Log::info('ZaimApiからカテゴリ情報を取得しました');
    } catch (Exception $e) {
      Log::error($e->getMessage());
    }
  }

  /**
   * ジャンル情報取得
   *
   * @return \Illuminate\Http\Response
   */
  public function genre(Request $request)
  {
    $token = DB::table('zaims')->where('user_id', 1)->first();
    if (empty($token)) return redirect('zaim_api');

    $content = '';
    try {
      // OAuth 認証
      $oauth = self::_oauth();
      // Zaim Api 呼び出し
      $content = self::_call($this->genre_url, $oauth, $request);

      $conArr = json_decode($content, true);

      if (empty($conArr['genres'])) exit;

      DB::table('zaim_genres')->delete();
      foreach ($conArr['genres'] as $c) {
        $input = [
          'genre_id'        => $c['id'],
          'name'            => $c['name'],
          'sort'            => $c['sort'],
          'active'          => $c['active'],
          'category_id'     => $c['category_id'],
          'parent_genre_id' => $c['parent_genre_id'],
          'modified'        => $c['modified'],
        ];
        DB::table('zaim_genres')->insert($input);
      }
      Log::info('ZaimApiからジャンル情報を取得しました');
    } catch (Exception $e) {
      Log::error($e->getMessage());
    }
  }

  /**
   * Zaim OAuth 認証
   *
   * @return \Illuminate\Http\Response
   */
  private function _oauth()
  {
    // Initialize HTTP_OAuth_Consumer
    $oauth = new HTTP_OAuth_Consumer($this->consumer_key, $this->consumer_secret);

    // Enable SSL
    $http_request = new HTTP_Request2();
    $http_request->setConfig('ssl_verify_peer', false);
    $consumer_request = new HTTP_OAuth_Consumer_Request;
    $consumer_request->accept($http_request);
    $oauth->accept($consumer_request);

    return $oauth;
  }

  /**
   * Zaim Api 呼び出し
   *
   * @return \Illuminate\Http\Response
   */
  private function _call($url, $oauth, $request)
  {
    // Accessing Protected Resources
    $oauth->setToken($request->session()->get('oauth_token'));
    $oauth->setTokenSecret($request->session()->get('oauth_token_secret'));

    $result = $oauth->sendRequest($url, array(), 'GET');
    return $result->getBody();
  }
}
