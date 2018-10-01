@extends('layouts.material2')

@section('headertitle')Your Tap '{{$tap->description}}' @endsection
@section('pagetitle')Your Tap '{{$tap->description}}' @endsection
@section('pageColour', 'green')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12 mx-auto text-center">
                    @foreach (['danger', 'warning', 'success', 'info'] as $key)
                        @if(Session::has($key))
                            <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                        @endif
                    @endforeach
                    ({{$tap->uid}})

                </div>
                <div class="col-lg-4 mx-auto text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                    {{ Form::model($tap, array('route' => array('taps.changestatus', $tap->id))) }}
                    {{ Form::select('status', $statuses, null, ['class' => 'form-control form-control-sm']) }}

                    {{ $tap->status }}
                    {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}</div>
                        </div></div></div>
                <hr class="light"/>

                <div class="col-lg-4 mx-auto text-center">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                    {{ Form::model($tap, array('route' => array('taps.turntap', $tap->id))) }}
                    The Tap should
                    be {{ Form::select('expected_state', $onOrOffs, null, ['class' => 'form-control form-control-sm']) }}
                    for {{ Form::select('off_for_minutes', $timeLengths, null, ['class' => 'form-control form-control-sm']) }}

                    @if ($tap->expected_state != $tap->reported_state)
                        Expected state: {{$tap->expected_state}},
                    @endif
                    Current State: {{$tap->reported_state}}
                    @if ($tap->hasSchedule())
                        {{$tap->getTurnOffDate()}}
                    @endif
                    {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                            </div></div></div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                    <h3>Pretending to be a tap</h3>

                    {{ Form::model($tap, array('route' => array('taps.sendFakeResponse', $tap->id))) }}
                    {{ Form::select('reported_state', $onOrOffs, null, ['class' => 'form-control form-control-sm']) }}
                    {{ Form::submit('Pretend to respond to tap state change', ['class' => 'btn btn-debug']) }}
                    {{ Form::Close() }}
                            </div></div></div>

                </div>
            </div>
        </div>
        <div class="col-lg-4 mx-auto text-center">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <h3 class="section-heading "><b>Attached Sensors</b></h3>

                        @if  (count($sensors) > 0)
                            <h3>{{count($sensors)}} sensor{{(count($sensors) == 1 ? ' controls':'s control')}} this tap</h3>
                            @foreach ($sensors as $sensor)
                                <p>
                                    {{ $sensor->description }}
                                    @if (!$sensor->isActive())
                                        (inactive)
                                    @endif
                                    ({{$sensor->last_reading}}%)
                                    <br/>
                                    <a href="{{$sensor->getUrl()}}" class="btn btn-primary view">Show</a>
                                </p>
                            @endforeach
                        @else
                            There are no sensors connected to this tap yet
                        @endif

                        @if  (count($allSensors) > 0)
                            {{ Form::model($tap, array('route' => array('taps.connectToSensor', $tap->id))) }}
                            {{ Form::select('sensor_id', $allSensors, null, ['class' => 'form-control']) }}

                            {{ Form::submit('Control Tap with this Sensor', ['class' => 'btn btn-primary']) }}
                            {{Form::Close()}}
                        @endif                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection
