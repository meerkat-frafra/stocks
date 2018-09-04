@extends('layouts.app')

@section('content')

<div class="container">

    <h1>Edit Stock</h1>

    {{ Form::open(['url' => '/stocks/update']) }}
        <div class="form-group">
          <label for="name">Name</label>
          @if ($errors->has('name'))
          {{ Form::text('name', $input['name']?? '', ['required' => true, 'class' => 'form-control is-invalid', 'id' => 'name', 'placeholder' => 'input name.']) }}
          <div class="invalid-feedback">
            {{ $errors->first('name') }}
          </div>
          @else
          {{ Form::text('name', $input['name']?? '', ['required' => true, 'class' => 'form-control', 'id' => 'name', 'placeholder' => 'input name.']) }}
          @endif
        </div>
        <div class="form-group">
          <label for="space">Space</label>
          @if ($errors->has('space'))
          {{ Form::select('space', $m_space, $input['place']?? '', ['class' => 'form-control is-invalid', 'id' => 'space']) }}
          <div class="invalid-feedback">
            {{ $errors->first('space') }}
          </div>
          @else
          {{ Form::select('space', $m_space, $input['place']?? '', ['class' => 'form-control', 'id' => 'space']) }}
          @endif
        </div>
        <div class="form-group">
          <label for="limit">Limit</label>
          @if ($errors->has('limit'))
          {{ Form::text('limit', $input['limit']?? '', ['type' => 'date', 'class' => 'form-control is-invalid', 'id' => 'limit', 'placeholder' => 'input date.']) }}
          <div class="invalid-feedback">
            {{ $errors->first('limit') }}
          </div>
          @else
          {{ Form::text('limit', $input['limit']?? '', ['type' => 'date', 'class' => 'form-control', 'id' => 'limit', 'placeholder' => 'input date.']) }}
          @endif
          
        </div>
        <div class="form-group">
          <label for="memo">Memo</label>
          {{ Form::textarea('memo', $input['memo']?? '', ['class' => 'form-control', 'id' => 'memo', 'rows' => 3, 'placeholder' => 'shop, price, purchase date, etc.']) }}
        </div>

        {{ Form::hidden('id', $input['id']) }}
        {{ Form::hidden('isStock', $isStock) }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-primary btn-lg btn-block">Update Stock</button>
      
      {{ Form::close() }}

</div>

@endsection