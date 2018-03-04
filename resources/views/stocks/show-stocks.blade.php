@extends('layouts.dashboard')

@section('template_title')
  Showing Stocks
@endsection

@section('header')
    Showing Stocks
@endsection

@php
    $totalStocks = count($stocks);
    $enableDataTablesCount = 50;
@endphp

@section('template_fastload_css')
    .mdl-badge[data-badge]:after {
        background-color: inherit;
    }
@endsection

@section('breadcrumbs')

    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
        <a itemprop="item" href="{{url('/')}}">
            <span itemprop="name">
                {{ trans('titles.app') }}
            </span>
        </a>
        <i class="material-icons">chevron_right</i>
        <meta itemprop="position" content="1" />
    </li>
    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="active">
        <a itemprop="item" href="/stocks" class="">
            <span itemprop="name">
                Stocks
            </span>
        </a>
        <meta itemprop="position" content="2" />
    </li>

@endsection

@section('content')
    <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--8-col-tablet mdl-cell--12-col-desktop margin-top-0">
        <div class="mdl-card__title mdl-color--primary mdl-color-text--white">
            <h2 class="mdl-card__title-text logo-style">
                @if ($totalStocks === 1)
                    {{ $totalStocks }} Stocks total
                @elseif ($totalStocks > 1)
                    {{ $totalStocks }} Total Stocks
                @else
                    No Stocks :(
                @endif
            </h2>

        </div>
        <div class="mdl-card__supporting-text mdl-color-text--grey-600 padding-0 context">
            <div class="table-responsive material-table">
                <table id="stocks_table" class="mdl-data-table mdl-js-data-table data-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th class="mdl-data-table__cell--non-numeric">{{ trans('stocks.stocksStatus') }}</th>
                            <th class="mdl-data-table__cell--non-numeric mdl-layout--large-screen-only">{{ trans('stocks.stocksUsers') }}</th>
                            <th class="mdl-data-table__cell--non-numeric">{{ trans('stocks.stocksName') }}</th>
                            {{-- <th class="mdl-data-table__cell--non-numeric mdl-layout--large-screen-only">{{ trans('stocks.stocksLink') }}</th> --}}
                            <th class="mdl-data-table__cell--non-numeric no-sort no-search">{{ trans('stocks.stocksActions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks as $stock)
                            @php
                                $stockStatus = [
                                    'name'  => trans('stocks.statusDisabled'),
                                    'class' => 'mdl-color--red-400'
                                ];
                                if($stock->status == 1) {
                                    $stockStatus = [
                                        'name'  => trans('stocks.statusEnabled'),
                                        'class' => 'mdl-color--green-400'
                                    ];
                                }

                                $stockUsers = 0;
                                $stockCountClass = 'primary';
                                foreach($users as $user) {
                                    if($user->profile && $user->profile->stock_id === $stock->id) {
                                       $stockUsers += 1;
                                    }
                                }
                                $stockCountClass = 'mdl-color--grey-400';
                                if($stockUsers === 1) {
                                    $stockCountClass = 'mdl-color--blue-400';
                                } elseif($stockUsers >= 2) {
                                    $stockCountClass = 'mdl-color--orange-400';
                                } elseif($stockUsers === 5) {
                                    $stockCountClass = 'mdl-color--green-400';
                                } elseif($stockUsers === 10) {
                                    $stockCountClass = 'mdl-color--red-400';
                                }
                            @endphp
                            <tr>
                                <td class="mdl-data-table__cell--non-numeric ">
                                    <span class="badge mdl-color-text--white {{ $stockStatus['class'] }}">
                                        {{ $stockStatus['name'] }}
                                    </span>
                                </td>
                                <td class="mdl-layout--large-screen-only">
                                    <div class="material-icons mdl-badge mdl-badge--overlap {{ $stockCountClass }}" data-badge="{{ $stockUsers }}"></div>
                                </td>
                                <td class="mdl-data-table__cell--non-numeric ">{{$stock->name}}</td>
                                {{--
                                    <td class="mdl-data-table__cell--non-numeric  mdl-layout--large-screen-only">
                                        @if($stock->link != 'null')
                                            <a href="{{$stock->link}}" target="_blank" id="stock_tooltip_{{$stock->id}}">
                                                {{$stock->link}}
                                            </a>
                                            <span class="mdl-tooltip mdl-tooltip--top" for="stock_tooltip_{{$stock->id}}">
                                                Go to Link
                                            </span>
                                        @else
                                            {{$stock->link}}
                                        @endif
                                    </td>
                                --}}
                                <td class="mdl-data-table__cell--non-numeric">
                                    <a href="/stocks/{{$stock->id}}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="{{ trans('stocks.stocksBtnShow') }}" id="view_stock_{{$stock->id}}">
                                        <i class="material-icons mdl-color-text--green-500" aria-hidden="true">remove_red_eye</i>
                                        <span class="sr-only">{{ trans('stocks.stocksBtnShow') }}</span>
                                        <span class="mdl-tooltip mdl-tooltip--top" for="view_stock_{{$stock->id}}">
                                            {{ trans('stocks.stocksBtnShow') }}
                                        </span>
                                    </a>
                                    <a href="/stocks/{{$stock->id}}/edit" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" title="{{ trans('stocks.stocksBtnShow') }}" id="edit_stock_{{$stock->id}}">
                                        <i class="material-icons mdl-color-text--orange-500" aria-hidden="true">create</i>
                                        <span class="sr-only">{{ trans('stocks.stocksBtnEdit') }}</span>
                                        <span class="mdl-tooltip mdl-tooltip--top" for="edit_stock_{{$stock->id}}">
                                            {{ trans('stocks.stocksBtnEdit') }}
                                        </span>
                                    </a>

                                    {!! Form::open(['url' => 'stocks/' . $stock->id, 'method' => 'delete', 'class' => 'inline-block', 'id' => 'delete_'.$stock->id]) !!}
                                        {!! Form::hidden('_method', 'DELETE') !!}
                                        <a href="#" class="dialog-button dialiog-trigger-delete dialiog-trigger{{$stock->id}} mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect" data-stockid="{{$stock->id}}" id="delete_stock_{{$stock->id}}">
                                            <i class="material-icons mdl-color-text--red" aria-hidden="true">delete</i>
                                            <span class="sr-only">{{ trans('stocks.stocksBtnDelete') }}</span>
                                            <span class="mdl-tooltip mdl-tooltip--top" for="delete_stock_{{$stock->id}}">
                                                {{ trans('stocks.stocksBtnDelete') }}
                                            </span>
                                        </a>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mdl-card__menu" style="top: -4px;">

            @include('partials.mdl-highlighter')

            @if ($totalStocks > $enableDataTablesCount)
                @include('partials.mdl-search')
            @endif

            <a href="{{ url('/stocks/create') }}" class="mdl-button mdl-button--icon mdl-js-button mdl-js-ripple-effect mdl-color-text--white" title="Add New User" id="add_stock">
                <i class="material-icons" aria-hidden="true">add</i>
                <span class="sr-only">{{ trans('stocks.btnAddStock') }}</span>
                <span class="mdl-tooltip mdl-tooltip--top" for="add_stock">
                    Add
                </span>
            </a>

        </div>
    </div>

    @include('dialogs.dialog-delete')

@endsection

@section('footer_scripts')

    @if ($totalStocks > $enableDataTablesCount)
        @include('scripts.mdl-datatables')
    @endif

    @include('scripts.highlighter-script')

    <script type="text/javascript">
        @foreach ($stocks as $stock)
            mdl_dialog('.dialiog-trigger{{$stock->id}}','','#dialog_delete');
        @endforeach
        var stockid;
        $('.dialiog-trigger-delete').click(function(event) {
            event.preventDefault();
            stockid = $(this).attr('data-stockid');
        });
        $('#confirm').click(function(event) {
            $('form#delete_'+stockid).submit();
        });
    </script>

@endsection
