@extends('layouts.app')

@section('content')

<div class="container">

<h1>ゲーム部屋に入る</h1>

    <form action='/game/entryin' method='get'>
    <div>
        こちらは、{{ $game_rooms->owner }} さんのゲーム部屋です。
        <br>
        ニックネームを入力の上、入室してください。
    </div>
    <div>
        ニックネーム：<input type="text" name="nickname">
    </div>
    <div style='margin-top: 10px;'>
        <input type='submit' value='ゲーム部屋に入る' class="btn btn-primary btn-lg btn-block" >
        <input type='hidden' value='{{ $game_rooms->id }}' name="roomId">
    </div>
    </form>

</div>

@endsection