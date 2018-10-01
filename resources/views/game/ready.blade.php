@extends('layouts.app')

@section('content')

<div class="container">

    @if ($me['isOwner'] == 1)
    <h1>メンバーが揃ったら、ゲームを開始してください</h1>
    @else
    <h1>部屋が準備できるまで少しお待ちください</h1>
    @endif

    @if ($me['isOwner'] == 1)
    <!-- LINEで友達を誘う -->
    <a class="btn btn-primary btn-lg btn-block" href="/stocks/create" role="button" aria-expanded="false" aria-controls="collapseExample">
        LINEで送る
    </a>

    <!-- QRコードで友達を誘う -->
    <div style='width: 100px; height: 100px; background-color:#666; margin: 10px 0;'></div>

    <!-- URLをメールなどで送る -->
    <a class="btn btn-primary btn-lg btn-block" href="/game/entry/{{ $rooms->id }}" target="_blank" role="button" aria-expanded="false" aria-controls="collapseExample">
        /game/entry/{{ $rooms->id }}
    </a>
    <div style='height: 10px; margin: 10px 0;'></div>
    @endif

    <!-- 参加者一覧 -->
    <h3>ゲーム部屋参加者（{{ $rooms->id }}）</h3><sup id="memberCnt">現在　{{ $members->count() }}名</sup>
    <div id="member" style='margin:30px 0;'>
        <ul>
         @foreach($members as $member)
            <li>
                @if($member->isOwner == 1) 主催者: @else 参加者: @endif
                {{ $member->name }}
            </li>
         @endforeach
        </ul>
    </div>

    @if ($me['isOwner'] == 1)
    <!-- ゲームを始める -->
    <a class="btn btn-primary btn-lg btn-block" href="/game/showroom" role="button" aria-expanded="false" aria-controls="collapseExample">
        ゲーム開始
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

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-trump1', function(data) {
    //   alert(JSON.stringify(data));
        location.reload();
    });

    var channel = pusher.subscribe('my-channel2');
    channel.bind('my-trump2', function(data) {
    //   alert(data.message);
    //   console.log(location.pathname);
    //   console.log(location.pathinfo);
    // alert(location.host + '/' + location.pathname);
      location.href= '\/\/' + location.host + '/game/showroom2';
    });
  </script>

@endsection