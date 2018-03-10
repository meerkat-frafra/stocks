<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsumeController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * 商品の残量を更新する
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

    }

    /**
     * 商品の詳細を参照
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * 商品を冷蔵庫に移動
     *
     * @return \Illuminate\Http\Response
     */
    public function toRefrigerator($id)
    {

    }

    /**
     * 商品を冷凍庫に移動
     *
     * @return \Illuminate\Http\Response
     */
    public function toFreezer($id)
    {

    }

    /**
     * 商品を貯蔵庫に移動
     *
     * @return \Illuminate\Http\Response
     */
    public function toPantry($id)
    {

    }

    /**
     * 買い物リストから削除
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    /**
     * 商品を買ったので買い物リストから除外する
     *
     * @return \Illuminate\Http\Response
     */
    public function back($id)
    {

    }
}
