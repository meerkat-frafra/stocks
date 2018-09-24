@extends('layouts.app')

@section('content')

<div class="container">

<h1>カードゲームをはじめる</h1>

    <form action='/game/room' method='get'>
    <div>
        ニックネーム：<input type="text" name="nickname">
    </div>
    <div style='margin-top: 10px;'>
        <input type='submit' value='ゲーム部屋を作る' class="btn btn-primary btn-lg btn-block" >
    </div>
    </form>

</div>

@endsection