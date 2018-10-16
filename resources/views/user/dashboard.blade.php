@extends('layouts.material2')

@section('headertitle') Welcome to your dashboard @endsection
@section('pagetitle') Dribly Dashboard @endsection
@section('dashboardNavHighlight', 'active')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">Welcome</h4>
                </div>
                <div class="card-body">
                    <p class="text-faded">Just attach the tap using hoselock connectors to your system, and use an
                        online timer for free. Get a sensor (subscription required) and we will keep the garden watered.
                        Monitor on our Dribly app and your garden will be wet all year.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">brightness_medium</i>
                    </div>
                    <p class="card-category">Water Sensors</p>
                    <h3 class="card-title">{{count($sensors)}}</h3>
                </div>
                <div class="card-body">
                    @foreach ($sensors as $sensor)
                        <div class="row">
                            <div class="col-md-auto">{{$sensor->name}}</div>
                            <div class="col-mr-auto">@if(!is_null($sensor->last_reading)){{$sensor->last_reading}}%@endif</div>
                            <div class="col-sm-2">

                                <a href="{{$sensor->getUrl()}}" rel="tooltip" title="Show"
                                   class="btn btn-warning btn-link btn-sm"
                                   data-original-title="Show">
                                    <i class="material-icons">visibility</i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="card-footer">
                    <div class="btn btn-sm btn-warning">
                        <i class="material-icons text-white">add</i>
                        <a href="{{route('sensors.add')}}" class=" text-white">Add a new sensor...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">opacity</i>
                    </div>
                    <p class="card-category">Tap Controllers</p>
                    <h3 class="card-title">{{count($taps)}}</h3>
                </div>
                <div class="card-body">
                    @foreach ($taps as $tap)
                        <div class="row">
                            <div class="col-sm-8">{{$tap->name}}</div>
                            <div class="col-sm-2">{{ucfirst($tap->reported_state)}}</div>
                            <div class="col-sm-2"
                            ">
                            <a href="{{$tap->getUrl()}}" rel="tooltip" title="Show"
                               class="btn btn-success btn-link btn-sm"
                               data-original-title="Show">
                                <i class="material-icons">visibility</i>
                            </a>
                        </div>
                </div>
                @endforeach
            </div>
            <div class="card-footer">
                <div class=" btn btn-sm btn-success">
                    <i class="material-icons text-white">add</i>
                    <a href="{{route('taps.add')}}" class="text-white">Add a new tap...</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{--<a class="btn btn-default btn-xl js-scroll-trigger" href="#services">Get Started!</a>--}}


@endsection
