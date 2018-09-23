@extends('layouts.app')

@section('content')

<div class="container">

<h1>ゲーム中</h1>

    <div>
        引く人：あなたの番です
    </div>
    
    <hr>
    <!-- 相手のカード -->
    <div>
        取りたいカードを選んでください
    </div>
    <ul>
        <li style="clear:both;"">
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
    </ul>

    <!-- 手持ちのカード -->
    <h3>手持ちのカード</h3>
    <ul>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
        <li>
            <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>
        </li>
    </ul>

    <hr>

    <!-- 参加者一覧 -->
    <h3>ゲーム参加者</h3><sup>現在　2名<sup>
    <ul>
        <li>lion　（本人）</li>
        <li>lion　（残り2枚）</li>
        <li>cat　（残り5枚）</li>
    </ul>


    <!-- ゲームを始める -->
    <a class="btn btn-primary btn-lg btn-block" href="/stocks/create" role="button" aria-expanded="false" aria-controls="collapseExample">
        ゲーム開始
    </a>


</div>

@endsection