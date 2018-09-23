@extends('layouts.fumi_app')

@section('content')

<header>
  <h1>食品</h1>
  <div id="nav-drawer">
    <input id="nav-input" type="checkbox" class="nav-unshown">
    <label id="nav-open" for="nav-input"><span></span></label>
    <label id="nav-close" for="nav-input" class="nav-unshown"></label>
    <nav>
      <ul>
        <li><a href="#">食品</a></li>
        <li><a href="#">雑貨</a></li>
        <li><a href="#">ナビ3</a></li>
        <li><a href="#">ナビ4</a></li>
      </ul>
    </nav>
  </div>
</header>
<section>
@foreach($stocks as $num => $data)
<article>
  <div class="image"><img src="" alt="{{ $data->name }}" style="padding:5px; border: 1px solid #666;"></div>
  <h2>{{ $data->name }}</h2>
  <div class="stock">
   <img src="/images/happy.png" alt="十分足りてます" class="active" style="width:40px;">
   <img src="/images/normal.png" alt="ちょっと足りない" class="no-active" style="width:40px;">
   <img src="/images/sad.png" alt="無くなった" class="no-active" style="width:40px;">
  </div>
  <div class=""><img src="" alt="購入リクエスト"></div>
  <!-- <a href="#" class="btn">&gt;もっと見る</a> -->
</article>
@endforeach
</section>
<footer>
<div>{{ $stocks->count() }}件</div>
</footer>

@endsection