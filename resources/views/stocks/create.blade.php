@extends('layouts.app')

@section('content')

<div class="container">

    <h1>商品追加</h1>

    {{ Form::open(['url' => '/stocks/store']) }}
        <div class="form-group">
          <label for="name">商品名</label>
          @if ($errors->has('name'))
          {{ Form::text('name', null, ['required' => true, 'class' => 'form-control is-invalid', 'id' => 'name', 'placeholder' => 'input name.']) }}
          <div class="invalid-feedback">
            {{ $errors->first('name') }}
          </div>
          @else
          {{ Form::text('name', null, ['required' => true, 'class' => 'form-control', 'id' => 'name', 'placeholder' => 'input name.']) }}
          @endif
        </div>
        <div class="form-group">
          <label for="space">置き場</label>
          @if ($errors->has('space'))
          {{ Form::select('space', $m_space, null, ['class' => 'form-control is-invalid', 'id' => 'space']) }}
          <div class="invalid-feedback">
            {{ $errors->first('space') }}
          </div>
          @else
          {{ Form::select('space', $m_space, null, ['class' => 'form-control', 'id' => 'space']) }}
          @endif
        </div>
        <div class="form-group">
          <label for="limit">消費期限</label>
          @if ($errors->has('limit_date'))
          {{ Form::input('date', 'limit_date', null, ['class' => 'form-control is-invalid', 'id' => 'limit_date', 'placeholder' => '置き場を選択してください']) }}
          <div class="invalid-feedback">
            {{ $errors->first('limit_date') }}
          </div>
          @else
          {{ Form::input('date', 'limit_date', null, ['class' => 'form-control', 'id' => 'limit_date', 'placeholder' => '日付を入力してください']) }}
          @endif
          
        </div>
        <div class="form-group">
          <label for="memo">メモ</label>
          {{ Form::textarea('memo', null, ['class' => 'form-control', 'id' => 'memo', 'rows' => 3, 'placeholder' => '店舗名、金額、購入日など']) }}
        </div>

        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary btn-lg btn-block">商品追加</button>

        <div style="margin-top:20px; text-align:center;"><a href="/stocks">一覧に戻る</a></div>
      
      {{ Form::close() }}

</div>

@endsection