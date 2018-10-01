@extends('layouts.app')

@section('content')

<div class="container">

<h1>ゲーム中</h1>

    @if ($room->target == $me['myMemberId'] && $room->wait != 1)
    <div>
        引く人：あなたの番です
    </div>
    
    <hr>
    <!-- 相手のカード -->
    <h3>取りたいカードを選んでください</h3>
    <div>
        @foreach($nextPerson as $card)
            <a href="/game/pull/{{$card}}">
                <img src="/assets/c/z02.gif" width="70px;">
            </a>
        @endforeach
    </div>

    @endif
    @if ($room->target != $me['myMemberId'] || $room->wait == 1)

    <!-- 手持ちのカード -->
    <h3>手持ちのカード</h3>
    <div>
        @foreach($me['myCards'] as $card)
            @if($card == $trash1)
                <img style='border:2px dotted red;' src="/assets/c/{{ $card }}.gif" width="70px;">
            @else
                <a href="/game/trash/{{$card}}">
                    <img src="/assets/c/{{ $card }}.gif" width="70px;">
                </a>
            @endif
        @endforeach
    </div>
    
    @endif
    @if ($room->target == $me['myMemberId'] && $room->wait == 1)
    <hr>
    <!-- カード引いた -->
    <a class="btn btn-primary btn-lg btn-block" href="/game/oke" role="button" aria-expanded="false" aria-controls="collapseExample">
        カード引いた！
    </a>
    @endif

</div>

  <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('f0f2cca95e39692282a2', {
      cluster: 'ap1',
      forceTLS: true
    });

    // var channel = pusher.subscribe('my-channel2');
    // channel.bind('my-trump2', function(data) {
    // //   alert(JSON.stringify(data));
    // location.reload();
    // });
    var channel = pusher.subscribe('my-channel3');
    channel.bind('my-trump3', function(data) {
        location.reload();
    });
  </script>

@endsection