@extends('layouts.dashboard')

@section('template_title')
  	{{ trans('stocks.showHeadTitle') . ' ' . $mdlStock->name }}
@endsection

@section('template_fastload_css')

	.list-group-responsive span:not(.label) {
		display: block;
		overflow-y: auto;
	}
	.list-group-responsive span.label {
		margin-left: 7.25em;
	}

	.stock-details-list strong {
		width: 5.5em;
		display: inline-block;
		position: absolute;
	}

	.stock-details-list span {
	  	margin-left: 5.5em;
	}

@endsection

@php
    $stockStatus = [
        'name'  => trans('stocks.statusDisabled'),
        'class' => 'danger'
    ];
    if($mdlStock->status == 1) {
        $stockStatus = [
            'name'  => trans('stocks.statusEnabled'),
            'class' => 'success'
        ];
    }
@endphp

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					{{ trans('stocks.showTitle') }}
					<a href="/stocks/" class="btn btn-primary btn-xs pull-right">
					  <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
					  {{ trans('stocks.showBackBtn') }}
					</a>
				</div>
				<div class="panel-body">
					<div class="well well-sm">
					    <h1 class="text-center">
					        {{ $mdlStock->name }}
					    </h1>

					    <h4 class="text-center margin-bottom-2">
					        <span class="badge">{{ count($stockUsers) }}</span> {{ trans('stocks.showUsers') }}
					    </h4>

						<ul class="list-group list-group-responsive stock-details-list margin-bottom-3">

							<li class="list-group-item">
								<strong>{{ trans('stocks.showStatus') }}</strong>
							    <span class="label label-{{ $stockStatus['class'] }}">
							        {{ $stockStatus['name'] }}
							    </span>
							</li>

							<li class="list-group-item"><strong>Id</strong> <span>{{ $mdlStock->id }}</span></li>

							@if($mdlStock->link != null)
								<li class="list-group-item"><strong>{{ trans('stocks.showLink') }}</strong> <span> <a href="{{$mdlStock->link}}" target="_blank" data-toggle="tooltip" title="Go to Link">{{$mdlStock->link}}</a></span></li>
							@endif

							@if($mdlStock->notes != null)
								<li class="list-group-item"><strong>{{ trans('stocks.showNotes') }}</strong> <span>{{ $mdlStock->notes }}</span></li>
							@endif

							<li class="list-group-item"><strong>{{ trans('stocks.showAdded') }}</strong> <span>{{ $mdlStock->created_at }}</span></li>
							<li class="list-group-item"><strong>{{ trans('stocks.showUpdated') }}</strong> <span>{{ $mdlStock->updated_at }}</span></li>
						</ul>

						@if(count($stockUsers) > 0)
							<h4 class="text-center margin-bottom-2">
							   	<i class="fa fa-users fa-fw" aria-hidden="true"></i> Stock Users
							</h4>

							<ul class="list-group">
								@foreach ($stockUsers as $stockUser)
								    <li class="list-group-item"><i class="fa fa-user fa-fw margin-right-1" aria-hidden="true"></i> {{ $stockUser->name }}</li>
								@endforeach
							</ul>
						@endif
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-xs-6">
							<a href="/stocks/{{$mdlStock->id}}/edit" class="btn btn-small btn-info btn-block">
								<i class="fa fa-pencil fa-fw" aria-hidden="true"></i> Edit<span class="hidden-xs hidden-sm"> this</span><span class="hidden-xs"> Stock</span>
							</a>
						</div>
						{!! Form::open(array('url' => 'stocks/' . $mdlStock->id, 'class' => 'col-xs-6')) !!}
							{!! Form::hidden('_method', 'DELETE') !!}
							{!! Form::button('<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> Delete<span class="hidden-xs hidden-sm"> this</span><span class="hidden-xs"> Stock</span>', array('class' => 'btn btn-danger btn-block btn-flat','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => trans('stocks.confirmDeleteHdr'), 'data-message' => trans('stocks.confirmDelete'))) !!}
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('modals.modal-delete')

@endsection

@section('footer_scripts')

	@include('scripts.delete-modal-script')
	@include('scripts.tooltips')

@endsection
