@extends('layouts.material')

@section('headertitle')Sensors @endsection
@section('pagetitle')Sensors @endsection

@section('content')

@foreach ($sensors as $sensor)
<p>{{$sensor->id}}: {{ $sensor->description }}
    @if ($sensor->last_reading)
        {{$sensor->last_reading}}% humidity
    @endif
    <a href="{{$sensor->getUrl()}}" class="btn btn-default">Show</a></p>
@endforeach
              <a class="btn btn-default btn-xl js-scroll-trigger btn-add" href="{{route('sensors.add')}}">Register a new sensor</a>

@endsection
