@extends('layouts.app')

@section('content')

<div class="container">

<h1>Stocks List</h1>

    <!-- <div class="alert alert-success" role="alert">
        Updated.
    </div> -->

    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Space</th>
          <th scope="col">Limit</th>
          <!--<th scope="col"></th>-->
          <th scope="col" colspan="2">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($stocks['data'] as $num => $data)
        <tr>
          <th scope="row">{{ $num +1 }}</th>
          <td><a href="/stocks/edit/{{ $data['id'] }}">{{ $data['name'] }}</a></td>
          <td>{{ $m_space[$data['space']] }}</td>
          <td>{{ $data['limit'] }}</td>
          <!--<td><input type="range" class="custom-range" min="0" max="5" id="customRange2"></td>-->
          <td width="10%">
            @if ($data['usage'] == 1)
              <img src="/images/happy.png" alt="happy" class="" style="max-width:60%;">
            @elseif ($data['usage'] == 2)
              <img src="/images/normal.png" alt="normal" class="" style="max-width:60%;">
            @else ($data['usage'] == 3)
            <img src="/images/sad.png" alt="sad" class="" style="max-width:60%;">
            @endif
          </td>
          <td>
            <a class="btn btn-info" href="/stocks/usage/1/{{ $data['id'] }}" role="button" aria-expanded="false" aria-controls="collapseExample">
              Well
            </a>
            <a class="btn btn-warning" href="/stocks/usage/2/{{ $data['id'] }}" role="button" aria-expanded="false" aria-controls="collapseExample">
              Half
            </a>
            <a class="btn btn-danger" href="/stocks/usage/3/{{ $data['id'] }}" role="button" aria-expanded="false" aria-controls="collapseExample">
              Empty
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <!--<button type="button" class="btn btn-primary btn-lg btn-block">Add Stock</button>-->
    <a class="btn btn-primary btn-lg btn-block" href="/stocks/create" role="button" aria-expanded="false" aria-controls="collapseExample">
        Add Stock
    </a>
    <!--<button type="button" class="btn btn-secondary btn-lg btn-block">Stocks History</button>-->
    <a class="btn btn-secondary btn-lg btn-block" href="/stocks/history" role="button" aria-expanded="false" aria-controls="collapseExample">
        Stocks History
    </a>


</div>

@endsection