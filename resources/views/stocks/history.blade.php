@extends('layouts.app')

@section('content')

<div class="container">

<h1>Stocks History</h1>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Space</th>
          <th scope="col">Limit</th>
          <th scope="col">Memo</th>
          <th scope="col" colspan="2">Status</th>
        </tr>
      </thead>
      <tbody>
        @foreach($nostocks['data'] as $num => $data)
        <tr>
          <th scope="row">{{ $num +1 }}</th>
          <td><a href="/stocks/edit/{{ $data['id'] }}">{{ $data['name'] }}</a></td>
          <td>{{ $m_space[$data['space']] }}</td>
          <td>{{ $data['limit'] }}</td>
          <td>{{ nl2br($data['memo']) }}</td>
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
            <a class="btn btn-success" href="/stocks/gotit/{{ $data['id'] }}" role="button" aria-expanded="false" aria-controls="collapseExample">
              I Got it!
            </a>
            <a class="btn btn-danger" href="/stocks/destroy/{{ $data['id'] }}" role="button" aria-expanded="false" aria-controls="collapseExample">
              I'm not buy it.
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <!--<button type="button" class="btn btn-secondary btn-lg btn-block">Back</button>-->
    <a class="btn btn-secondary btn-lg btn-block" href="/stocks" role="button" aria-expanded="false" aria-controls="collapseExample">
        Back
    </a>


</div>

@endsection