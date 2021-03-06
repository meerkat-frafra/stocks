@extends('layouts.app')

@section('content')

<div class="container">

<h1>Stocks - 在庫リスト</h1>

    <div class="alert alert-success" role="alert">
        <a href="/stocks/new">新しい一覧はこちら</a>
    </div>

    <table class="table">
      <thead>
        <tr>
          <!-- <th scope="col">#</th> -->
          <th scope="col">商品名</th>
          <th scope="col">置き場</th>
          <th scope="col">消費期限</th>
          <!--<th scope="col"></th>-->
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($stocks as $num => $data)
        <tr>
          <!-- <th scope="row">{{ $num +1 }}</th> -->
          <td><a href="/stocks/edit/{{ $data->id }}">{{ $data->name }}</a></td>
          <td>{{ $m_space[$data->space] }}</td>
          <td>@if ($data->usage == 1) {{ $data->limit_date }} @else No Stocks @endif</td>
          <!--<td><input type="range" class="custom-range" min="0" max="5" id="customRange2"></td>-->
          <td width="10%">
            @if ($data->usage == 1)
            <a class="btn" href="/stocks/usage/3/{{ $data->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
              <img src="/images/happy.png" alt="happy" class="" style="width:50px;">
            </a>
            @else ($data->usage == 3)
            <a class="btn" href="/stocks/usage/1/{{ $data->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">
              <img src="/images/sad.png" alt="sad" class="" style="width:50px;">
            </a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <!--<button type="button" class="btn btn-primary btn-lg btn-block">Add Stock</button>-->
    <a class="btn btn-primary btn-lg btn-block" href="/stocks/create" role="button" aria-expanded="false" aria-controls="collapseExample">
        商品追加
    </a>
    <!--<button type="button" class="btn btn-secondary btn-lg btn-block">Stocks History</button>-->
    <a class="btn btn-secondary btn-lg btn-block" href="/stocks/history" role="button" aria-expanded="false" aria-controls="collapseExample">
        在庫切れリスト
    </a>


</div>

@endsection