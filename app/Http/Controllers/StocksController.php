<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Google_Client;
use Google_Service_Books;

class StocksController extends Controller
{
    // var $stocks;
    // var $nostocks;

    // var $url1;
    // var $url2;

    var $m_space;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');

        // $this->url1 = 'stocks.json';
        // // $json1 = file_get_contents($this->url1);
        // // $json1 = json_decode($json1, true);
        // $json1 = self::getJson1();

        // $this->url2 = 'nostocks.json';
        // // $json2 = file_get_contents($this->url2);
        // // $json2 = json_decode($json2, true);
        // $json2 = self::getJson2();

        // $this->stocks = $json1;
        // $this->nostocks = $json2;

        $this->m_space = ['' => '選択してください', 1 => '冷蔵庫', 2 => '貯蔵庫', 3 => '冷凍庫', 4 => 'その他'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $stocks = $this->stocks;
        $m_space = $this->m_space;
        $stocks = DB::table('stocks')->get();

        // return redirect('stocks/new');
        return view('stocks.index', compact('stocks', 'm_space'));
    }

    public function create()
    {
        $m_space = $this->m_space;

        return view('stocks.create', compact('m_space'));
    }
 
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'space' => 'required|in:0,1,2,3',
            'limit_date' => '',
            'memo' => '',
        ]);
        
        $input = $request->all();

        if (!$input['limit_date']) $input['limit_date'] = '0000-00-00 00:00:00';
        if (!$input['memo']) $input['memo'] = '';

        unset($input['_token']);
        
        // $input['id'] = mt_rand();
        $input['usage'] = 1;
        $input['balance'] = 1;
        $input['category'] = 0;
        $input['shop'] = '';
        $input['author'] = 1;
        $input['rebuy'] = 0;
        $input['rank'] = 0;
        $input['price'] = 0;
        $input['is_sync'] = false;
        $input['receipt_id'] = '';
        $input['is_show'] = false;
        $input['purchase_date'] = date('Y-m-d H:i:s');
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');

        // $this->stocks['data'][] = $input;
        // $json = json_encode($this->stocks);
        // file_put_contents($this->url1, $json);
        // self::putJson1();

        DB::table('stocks')->insert($input);
        
        return redirect('/stocks');
    }
 
    // public function show($id)
    // {
    //     //
    // }
 
    public function edit($id)
    {
        $m_space = $this->m_space;
        $isStock = true;

        $input = DB::table('stocks')->where('id', $id)->first();
        
        // $key = array_search($id, array_column($this->stocks['data'], 'id'));
        // if ($key !== false) {
        //     $input = $this->stocks['data'][$key];
        // } else {
            
        //     $key = array_search($id, array_column($this->nostocks['data'], 'id'));
        //     if (!$key) abort(500, 'Record not found.');

        //     $input = $this->nostocks['data'][$key];
        //     $isStock = false;
            
        // }
        
        return view('stocks.edit', compact('input', 'isStock', 'm_space'));
        
    }
 
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'space' => 'required|in:0,1,2,3',
            'limit_date' => '',
            'memo' => '',
        ]);
        
        $input = $request->all();
        $id = $input['id'];

        if (!$input['limit_date']) $input['limit_date'] = '';
        if (!$input['memo']) $input['memo'] = '';

        unset($input['_token']);
        unset($input['id']);
        unset($input['isStock']);

        $input['updated_at'] = date('Y-m-d H:i:s');
        
        DB::table('stocks')->where('id', $id)->update($input);
        
        return redirect('/stocks');
    }
 
    public function destroy($id)
    {
        DB::table('stocks')->where('id', $id)->delete();

        return redirect('/stocks/history');

    }

    public function history()
    {
        // $nostocks = $this->nostocks;
        $m_space = $this->m_space;
        $nostocks = DB::table('stocks')->where('usage', 3)->get();

        return view('stocks.history', compact('nostocks', 'm_space'));
    }

    public function usage($size, $id)
    {
        /*
         * size 
         *  1 : well
         *  2 : half
         *  3 : empty
         * 
        */
        $input['usage'] = $size;
        $input['updated_at'] = date('Y-m-d H:i:s');
        DB::table('stocks')->where('id', $id)->update($input);

        return redirect('/stocks');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function fumi()
    {
        // $stocks = $this->stocks;
        $m_space = $this->m_space;
        $stocks = DB::table('stocks')->get();

        return view('stocks.fumi_index', compact('stocks', 'm_space'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function newindex()
    {
        // $stocks = $this->stocks;
        $m_space = $this->m_space;
        $stocks = DB::table('stocks')->get();

        return redirect('stocks');
        return view('stocks.newindex', compact('stocks', 'm_space'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function space($space)
    {
        // $stocks = $this->stocks;
        $m_space = $this->m_space;
        $stocks = DB::table('stocks')->where('space', $space)->get();

        return view('stocks.index', compact('stocks', 'm_space'));
        // return view('stocks.newindex', compact('stocks', 'm_space'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function zaim()
    {
        // $stocks = $this->stocks;
        $m_space = $this->m_space;

        $category = DB::table('zaim_categories')->get();
        $genre = DB::table('zaim_genres')->get();

        $stocks = DB::table('zaim_records')
        ->leftJoin('zaim_categories', 'zaim_records.category_id', '=', 'zaim_categories.category_id')
        ->leftJoin('zaim_genres', 'zaim_records.genre_id', '=', 'zaim_genres.genre_id')
        ->select('zaim_records.*', 'zaim_categories.name as category_name', 'zaim_genres.name as genre_name')
        ->whereNotIn('zaim_records.name', ['', '外税', '割引'])
        ->where('zaim_records.active', '1')
        ->where('zaim_records.category_id', '101')
        ->where('zaim_records.genre_id', '10101')
        ->orderBy('zaim_id', 'desc')
        ->orderBy('id', 'desc')
        ->get();

        return view('stocks.zaim', compact('stocks', 'm_space'));
    }

    public function zaimImport($id)
    {
        $stocks = DB::table('zaim_records')
        ->leftJoin('zaim_categories', 'zaim_records.category_id', '=', 'zaim_categories.category_id')
        ->leftJoin('zaim_genres', 'zaim_records.genre_id', '=', 'zaim_genres.genre_id')
        ->select('zaim_records.*', 'zaim_categories.name as category_name', 'zaim_genres.name as genre_name')
        ->where('zaim_records.id', $id)
        ->orderBy('zaim_id', 'desc')
        ->orderBy('id', 'desc')
        ->first();

        $input['name'] = $stocks->name;
        $input['category'] = $stocks->category_id;
        $input['space'] = 1;
        $input['limit_date'] = '0000-00-00';
        $input['memo'] = '';
        $input['usage'] = 1;
        $input['balance'] = 1;
        $input['category'] = 0;
        $input['shop'] = '';
        $input['author'] = 1;
        $input['rebuy'] = 0;
        $input['rank'] = 0;
        $input['price'] = 0;
        $input['is_sync'] = true;
        $input['receipt_id'] = $stocks->receipt_id;
        $input['is_show'] = false;
        $input['purchase_date'] = $stocks->date;
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');

        DB::table('stocks')->insert($input);

        return redirect('stocks/zaim');
    }

    public function zaimDelete($id)
    {
        $stocks = DB::table('zaim_records')->where('id', $id)->update(['active' => 9]);

        return redirect('stocks/zaim');
    }

    public function google()
    {

        // https://search.yahoo.co.jp/image/search?p=%E6%BF%83%E5%8E%9A%E4%BB%95%E7%AB%8B%E3%81%A6%E7%B5%B9%E3%81%A8%E3%81%86%E3%81%B5&dim=medium
        $client = new Google_Client();
        $client->setApplicationName("Client_Library_Examples");
        $client->setDeveloperKey("AIzaSyBFO18YUFPHOvBD5h3DMIqWURiVLoyjUDA");

        $service = new \Google_Service_Books($client);
        $optParams = array('filter' => 'free-ebooks');
        $results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

        foreach ($results as $item) {
        echo $item['volumeInfo']['title'], "<br /> \n";
        }
    }

}
