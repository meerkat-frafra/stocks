@extends('layouts.app')

@section('content')

<div class="container">

<h1>カードゲームをはじめる</h1>

    <div>
        ニックネーム：<input type="text">
    </div>
    <!-- LINEで友達を誘う -->
    <a class="btn btn-primary btn-lg btn-block" href="/stocks/create" role="button" aria-expanded="false" aria-controls="collapseExample">
        LINEで送る
    </a>

    <!-- QRコードで友達を誘う -->
    <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>

    <!-- 参加者一覧 -->
    <h3>ゲーム参加者</h3><sup>現在　2名<sup>
    <ul>
        <li>lion</li>
        <li>lion</li>
        <li>cat</li>
    </ul>


    <!-- ゲームを始める -->
    <a class="btn btn-primary btn-lg btn-block" href="/stocks/create" role="button" aria-expanded="false" aria-controls="collapseExample">
        ゲーム開始
    </a>


</div>

@endsection