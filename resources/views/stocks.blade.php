@extends('layouts.app')

@section('content')

<div class="row">
    <a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">在庫商品追加</a>
</div>

<div class="row">
    <table class="table">
        <thead>
            <tr>
            <th scope="col">ID</th>
            <th scope="col">商品名</th>
            <th scope="col">カテゴリ</th>
            <th scope="col">在庫状況</th>
            <th scope="col">再購入</th>
            <th scope="col">前回購入情報（最終購入日、店舗、金額）</th>

            </tr>
        </thead>
        <tbody>
            <tr>
            <th scope="row">1</th>
            <td>大根</td>
            <td>野菜</td>
            <td>50%</td>
            <td><a href="#" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">再購入</a></td>
            </tr>
            <tr>
            <th scope="row">2</th>
            <td>Jacob</td>
            <td>Thornton</td>
            <td>@fat</td>
            </tr>
            <tr>
            <th scope="row">3</th>
            <td>Larry</td>
            <td>the Bird</td>
            <td>@twitter</td>
            </tr>
        </tbody>
</table>
</div>
@endsection