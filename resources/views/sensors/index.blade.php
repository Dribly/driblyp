@extends('layouts.material2')

@section('headertitle')Sensors @endsection
@section('pagetitle')Sensors @endsection
@section('pageColour', 'orange')
@section('sensorsNavHighlight', 'active')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header card-header-warning">
                    <h4 class="card-title">All my sensors</h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="text-warning">
                        <th>ID</th>
                        <th>Name</th>
                        <th>Last Reading</th>
                        <th>&nbsp;</th>
                        </thead>
                        <tbody>
                        @foreach ($sensors as $sensor)
                            <tr>
                                <td>{{$sensor->id}}</td>
                                <td> {{ $sensor->description }}</td>
                                <td> @if ($sensor->last_reading)
                                        {{$sensor->last_reading}}% humidity
                                    @endif</td>
                                <td><a href="{{$sensor->getUrl()}}" class="btn btn-warning">Show</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-xl js-scroll-trigger btn-warning" href="{{route('sensors.add')}}">Register a new sensor</a>

@endsection
