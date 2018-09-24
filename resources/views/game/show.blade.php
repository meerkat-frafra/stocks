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
    
    <div>
        @foreach($memberCard[1] as $card)
            <a href="/game/pull/{{$card}}"><img src="/assets/c/z02.gif" width="80px;"></a>
        @endforeach
    </div>

    <!-- 手持ちのカード -->
    <h3>手持ちのカード</h3>
    <div>
        @foreach($memberCard[2] as $card)
            @if($card == $trash1)
                <img style='border:2px dotted red;' src="/assets/c/{{ $card }}.gif" width="80px;">
            @else
                <a href="/game/trash/{{$card}}">
                    <img src="/assets/c/{{ $card }}.gif" width="80px;">
                </a>
            @endif
        @endforeach
    </div>

    <hr>

</div>

@endsection