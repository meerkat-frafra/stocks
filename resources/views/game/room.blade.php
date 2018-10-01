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

    <!-- URLをメールなどで送る -->
    <a class="btn btn-primary btn-lg btn-block" href="/game/entry/{{ $roomId }}" target="_blank" role="button" aria-expanded="false" aria-controls="collapseExample">
        /game/entry/{{ $roomId }}
    </a>
    <div style='height: 10px; margin: 10px 0;'></div>

    <!-- 参加者一覧 -->
    <h3>ゲーム部屋参加者（{{ $roomId }}）</h3><sup id="memberCnt">現在　2名<sup>
    <div id="member" style='margin:30px 0;'>
         親：{{ $owner }}<br>

    </div>


    <!-- ゲームを始める -->
    <a class="btn btn-primary btn-lg btn-block" href="/game/show/{{$roomId}}" role="button" aria-expanded="false" aria-controls="collapseExample">
        ゲーム開始
    </a>


</div>

@endsection