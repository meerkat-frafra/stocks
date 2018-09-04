<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StocksController extends Controller
{
    var $stocks;
    var $nostocks;

    var $url1;
    var $url2;

    var $m_space;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');

        $this->url1 = 'stocks.json';
        // $json1 = file_get_contents($this->url1);
        // $json1 = json_decode($json1, true);
        $json1 = self::getJson1();

        $this->url2 = 'nostocks.json';
        // $json2 = file_get_contents($this->url2);
        // $json2 = json_decode($json2, true);
        $json2 = self::getJson2();

        $this->stocks = $json1;
        $this->nostocks = $json2;

        $this->m_space = ['' => '選択してください', 1 => 'Refrigerator', 2 => 'Pantry', 3 => 'Freezer', 4 => 'Other'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks = $this->stocks;
        $m_space = $this->m_space;

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
            'limit' => 'date',
            'memo' => '',
        ]);
        
        $input = $request->all();

        unset($input['_token']);
        
        $input['id'] = mt_rand();
        $input['usage'] = 1;
        $input['author'] = 'nonomura';
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');

        $this->stocks['data'][] = $input;
        // $json = json_encode($this->stocks);
        // file_put_contents($this->url1, $json);
        self::putJson1();
        
        return redirect('/stocks');
    }
 
    // public function show($id)
    // {
    //     //
    // }
 
    public function edit($id)
    {
        $m_space = $this->m_space;
        
        $input = [];
        $isStock = true;

        $key = array_search($id, array_column($this->stocks['data'], 'id'));
        if ($key !== false) {
            $input = $this->stocks['data'][$key];
        } else {
            
            $key = array_search($id, array_column($this->nostocks['data'], 'id'));
            if (!$key) abort(500, 'Record not found.');

            $input = $this->nostocks['data'][$key];
            $isStock = false;
            
        }
        
        return view('stocks.edit', compact('input', 'isStock', 'm_space'));
        
    }
 
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'space' => 'required|in:0,1,2,3',
            'limit' => 'date',
            'memo' => '',
        ]);
        
        $input = $request->all();

        unset($input['_token']);
        
        $input['id'] = mt_rand();
        $input['usage'] = 1;
        $input['author'] = 'nonomura';
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');

        $this->stocks['data'][] = $input;
        self::putJson1();
        
        return redirect('/stocks');
    }
 
    public function destroy($id)
    {
        $key = array_search($id, array_column($this->nostocks['data'], 'id'));
        unset($this->nostocks['data'][$key]);

        $this->nostocks['data'] = array_values($this->nostocks['data']);
        
        self::putJson2();

        return redirect('/stocks/history');

    }

    public function history()
    {
        $nostocks = $this->nostocks;
        $m_space = $this->m_space;
        
        return view('stocks.history', compact('nostocks', 'm_space'));
    }

    public function usage($size, $id)
    {
        /*
         * size 
         *  0 : well
         *  1 : half
         *  2 : empty
         * 
        */
        $now = date('Y-m-d H:i:s');

        $key = array_search($id, array_column($this->stocks['data'], 'id'));
        switch ($size) {
            case 1:
                $this->stocks['data'][$key]['usage'] = 1;
                $this->stocks['data'][$key]['updated_at'] = $now;
                break;
                
            case 2:
                $this->stocks['data'][$key]['usage'] = 2;
                $this->stocks['data'][$key]['updated_at'] = $now;
                break;

            case 3:
                $this->stocks['data'][$key]['usage'] = 3;
                $this->stocks['data'][$key]['updated_at'] = $now;
                
                $this->nostocks['data'][] = $this->stocks['data'][$key];
                self::putJson2();
                unset($this->stocks['data'][$key]);
                
                break;
            default:
        }
        self::putJson1();

        return redirect('/stocks');
    }

    public function gotit($id)
    {
        $now = date('Y-m-d H:i:s');

        $key = array_search($id, array_column($this->stocks['data'], 'id'));
        $this->nostocks['data'][$key]['usage'] = 1;
        $this->nostocks['data'][$key]['updated_at'] = $now;        

        $this->stocks['data'][] = $this->nostocks['data'][$key];
        self::putJson1();
        unset($this->nostocks['data'][$key]);
        self::putJson2();

        return redirect('/stocks/history');
    }

    private function putJson1() {
        $json = json_encode($this->stocks);
        return file_put_contents($this->url1, $json);
    }

    private function putJson2() {
        $json = json_encode($this->nostocks);
        return file_put_contents($this->url2, $json);
    }

    private function getJson1() {
        $json1 = file_get_contents($this->url1);
        return json_decode($json1, true);
    }

    private function getJson2() {
        $json2 = file_get_contents($this->url2);
        return json_decode($json2, true);
    }
}
