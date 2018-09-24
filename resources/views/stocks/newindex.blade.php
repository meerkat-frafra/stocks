@extends('layouts.app')

@section('stylesheet')
<link href="/css/new.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div class="container">

  <header>
    <h1 style="font-size: 32px;">Stocks</h1>
    <div id="nav-drawer">
      <input id="nav-input" type="checkbox" class="nav-unshown">
      <label id="nav-open" for="nav-input"><span></span></label>
      <label id="nav-close" for="nav-input" class="nav-unshown"></label>
      <nav>
        <ul>
          <li><a href="/stocks/new/space/1">冷蔵庫</a></li>
          <li><a href="/stocks/new/space/2">貯蔵庫</a></li>
          <li><a href="/stocks/new/space/3">冷凍庫</a></li>
          <li><a href="/stocks/new/space/4">その他</a></li>
          <li></li>
          <li><a href="/stocks/zaim">Zaim</a></li>
          <li><a href="/zaim_api">Zaim認証</a></li>
          <li><a href="/zaim_api/receipt">Zaimレシート情報取得</a></li>
          <li><a href="/zaim_api/category">Zaimカテゴリ情報取得</a></li>
          <li><a href="/zaim_api/genre">Zaimジャンル情報取得</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <section style="margin: 10px;">
    <div class="card-columns">
      @if ($stocks->count() == 0)
       <div style="margin:50px 0; text-align:center;">
        ストック食材はありません。
      </div>
      @endif
      @foreach($stocks as $num => $data)
      <div class="card">
        <!-- <img class="card-img-top" src="/assets/bread2.jpg" alt="Card image cap" style="width: 100%;height: 15vw;object-fit: cover;"> -->
        <div class="card-body">
          <h5 class="card-title" style="font-size:90%;"><a href="/stocks/edit/{{ $data->id }}">{{ mb_strimwidth($data->name, 0, 18, "...", 'UTF-8') }}</a></h5>
          <h6 class="card-subtitle mb-2 text-muted">
            <span class="badge badge-dark">{{ $m_space[$data->space] }}</span>
          </h6>
          <!-- <p class="card-text">{{ nl2br($data->memo) }}</p> -->
          <p class="card-text">
            @if ($data->usage == 1)
              <a class="btn" href="/stocks/usage/3/{{ $data->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                <img src="/images/happy.png" alt="happy" class="" style="width:50px;">
              </a>
            @else ($data->usage == 3)
              <a class="btn" href="/stocks/usage/1/{{ $data->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
                <img src="/images/sad.png" alt="sad" class="" style="width:50px;">
              </a>
            @endif
          </p>
          <!-- <p class="card-text">
            <small class="text-muted">@if ($data->usage == 1) 賞味期限： {{ $data->limit_date }} @else No Stocks @endif</small>
          </p> -->
        </div>
        <div class="card-footer">
          <small class="text-muted">賞味期限：@if ($data->usage == 1 && $data->limit_date != '0000-00-00') {{ preg_replace('/[0-9]{4}\//', '', str_replace('-', '/', $data->limit_date)) }} @else 不明 @endif</small>
        </div>
      </div>
      @endforeach
      </div>

      <div style="margin-top:20px;">
        <!--<button type="button" class="btn btn-primary btn-lg btn-block">Add Stock</button>-->
        <a class="btn btn-primary btn-lg btn-block" href="/stocks/create" role="button" aria-expanded="false" aria-controls="collapseExample">
            商品追加
        </a>
        <!--<button type="button" class="btn btn-secondary btn-lg btn-block">Stocks History</button>-->
        <a class="btn btn-secondary btn-lg btn-block" href="/stocks/history" role="button" aria-expanded="false" aria-controls="collapseExample">
            在庫切れリスト
        </a>
      </div>
    </div>

    
  </section>
</div>

@endsection