@extends('layouts.app')

@section('content')

<div class="container">

<h1>友達を招待する</h1>

    <!-- LINEで友達を誘う -->
    <a class="btn btn-primary btn-lg btn-block" href="/stocks/create" role="button" aria-expanded="false" aria-controls="collapseExample">
        LINEで送る
    </a>

    <!-- QRコードで友達を誘う -->
    <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>

    <!-- 参加者一覧 -->
    <h3>ゲーム部屋参加者（{{ $roomNumber }}）</h3><sup>現在　2名<sup>
    <div style='margin:30px 0;'>
        親：{{ $roomOwner }}<br>

    </div>


    <!-- ゲームを始める -->
    <a class="btn btn-primary btn-lg btn-block" href="/game/show/1" role="button" aria-expanded="false" aria-controls="collapseExample">
        ゲーム開始
    </a>


</div>

@endsection