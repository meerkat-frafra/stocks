@extends('layouts.app')

@section('content')

<div class="container">

    <h1>商品編集</h1>

    {{ Form::open(['url' => '/stocks/update']) }}
        <div class="form-group">
          <label for="name">商品名</label>
          @if ($errors->has('name'))
          {{ Form::text('name', $input->name ?? '', ['required' => true, 'class' => 'form-control is-invalid', 'id' => 'name', 'placeholder' => 'input name.']) }}
          <div class="invalid-feedback">
            {{ $errors->first('name') }}
          </div>
          @else
          {{ Form::text('name', $input->name ?? '', ['required' => true, 'class' => 'form-control', 'id' => 'name', 'placeholder' => 'input name.']) }}
          @endif
        </div>
        <div class="form-group">
          <label for="space">置き場</label>
          @if ($errors->has('space'))
          {{ Form::select('space', $m_space, $input->space ?? '', ['class' => 'form-control is-invalid', 'id' => 'space']) }}
          <div class="invalid-feedback">
            {{ $errors->first('space') }}
          </div>
          @else
          {{ Form::select('space', $m_space, $input->space ?? '', ['class' => 'form-control', 'id' => 'space']) }}
          @endif
        </div>
        <div class="form-group">
          <label for="limit">消費期限</label>
          @if ($errors->has('limit_date'))
          {{ Form::input('date', 'limit_date', $input->limit_date ?? '', ['class' => 'form-control is-invalid', 'id' => 'limit_date', 'placeholder' => 'input date.']) }}
          <div class="invalid-feedback">
            {{ $errors->first('limit_date') }}
          </div>
          @else
          {{ Form::input('date', 'limit_date', $input->limit_date ?? '', ['class' => 'form-control', 'id' => 'limit_date', 'placeholder' => 'input date.']) }}
          @endif
          
        </div>
        <div class="form-group">
          <label for="memo">メモ</label>
          {{ Form::textarea('memo', $input->memo ?? '', ['class' => 'form-control', 'id' => 'memo', 'rows' => 3, 'placeholder' => 'shop, price, purchase date, etc.']) }}
        </div>

        {{ Form::hidden('id', $input->id) }}
        {{ Form::hidden('isStock', $isStock) }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary btn-lg btn-block">商品編集</button>
        
        <div style="margin-top:20px; text-align:center;"><a href="/stocks">一覧に戻る</a></div>
      
      {{ Form::close() }}

</div>

@endsection