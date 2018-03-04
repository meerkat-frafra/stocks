@extends('layouts.dashboard')

@section('template_title')
  {{ trans('titles.adminStocksAdd') }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">

            {{ trans('titles.adminStocksAdd') }}

            <a href="/stocks" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Stocks</span>
            </a>

          </div>
          <div class="panel-body">

            {!! Form::open(array('action' => 'StocksManagementController@store', 'method' => 'POST', 'role' => 'form')) !!}

              {!! csrf_field() !!}

              <div class="form-group has-feedback row {{ $errors->has('status') ? ' has-error ' : '' }}">
                {!! Form::label('status', trans('stocks.statusLabel') , array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <label class="switch checked" for="status">
                    <span class="active"><i class="fa fa-toggle-on fa-2x"></i> {{ trans('stocks.statusEnabled') }}</span>
                    <span class="inactive"><i class="fa fa-toggle-on fa-2x fa-rotate-180"></i> {{ trans('stocks.statusDisabled') }}</span>
                    <input type="radio" name="status" value="1" checked>
                    <input type="radio" name="status" value="0">
                  </label>

                  @if ($errors->has('status'))
                    <span class="help-block">
                      <strong>{{ $errors->first('status') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                {!! Form::label('name', trans('stocks.nameLabel') , array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                    <div class="input-group">
                      {!! Form::text('name', old('name'), array('id' => 'name', 'class' => 'form-control', 'placeholder' => trans('stocks.namePlaceholder'))) !!}
                      <label class="input-group-addon" for="name"><i class="fa fa-fw fa-pencil }}" aria-hidden="true"></i></label>
                    </div>
                @if ($errors->has('name'))
                  <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('link') ? ' has-error ' : '' }}">
                {!! Form::label('link', trans('stocks.linkLabel'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                    <div class="input-group">
                      {!! Form::text('link', old('link'), array('id' => 'link', 'class' => 'form-control', 'placeholder' => trans('stocks.linkPlaceholder'))) !!}
                      <label class="input-group-addon" for="link"><i class="fa fa-fw fa-link fa-rotate-90" aria-hidden="true"></i></label>
                    </div>
                @if ($errors->has('link'))
                  <span class="help-block">
                    <strong>{{ $errors->first('link') }}</strong>
                  </span>
                @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('notes') ? ' has-error ' : '' }}">
                {!! Form::label('notes', trans('stocks.notesLabel') , array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                    <div class="input-group">
                      {!! Form::textarea('notes', old('notes'), array('id' => 'notes', 'class' => 'form-control', 'placeholder' => trans('stocks.notesPlaceholder'))) !!}
                      <label class="input-group-addon" for="notes"><i class="fa fa-fw fa-pencil }}" aria-hidden="true"></i></label>
                    </div>
                @if ($errors->has('notes'))
                  <span class="help-block">
                    <strong>{{ $errors->first('notes') }}</strong>
                  </span>
                @endif
                </div>
              </div>

              {!! Form::button('<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;' . trans('stocks.btnAddStock'), array('class' => 'btn btn-success btn-flat margin-bottom-1 pull-right','type' => 'submit', )) !!}

            {!! Form::close() !!}

          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('footer_scripts')

  @include('scripts.toggleStatus')

@endsection
