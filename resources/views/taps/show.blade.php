@extends('layouts.bootstrap')

@section('headertitle')Taps @endsection
@section('pagetitle')Your Tap '{{$tap->description}}'@endsection

@section('content')
    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <a class=" text-white" href="{{route('taps.index', [])}}">&laquo; Back to Taps </a>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    @foreach (['danger', 'warning', 'success', 'info'] as $key)
                        @if(Session::has($key))
                            <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                        @endif
                    @endforeach
                    <h2 class="section-heading text-white">Tap: {{$tap->description}}</h2>
                    <hr class="light">
                        <div class="col-lg-3 mx-auto text-center">
                    {{ Form::model($tap, array('route' => array('taps.changestatus', $tap->id))) }}
                    {{ Form::select('status', $statuses, null, ['class' => 'form-control form-control-sm']) }}

                    {{ $tap->status }}
                    {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}</div>
                    <hr class="light"/>

                    {{ Form::model($tap, array('route' => array('taps.turntap', $tap->id))) }}
                        <div class="col-lg-3 mx-auto text-center">
                           The Tap should be  {{ Form::select('expected_state', $onOrOffs, null, ['class' => 'form-control form-control-sm']) }}
                        </div>
                            <div class="col-lg-6 mx-auto text-center">
                            for {{ Form::select('off_for_minutes', $timeLengths, null, ['class' => 'form-control form-control-sm']) }}

                    @if ($tap->expected_state != $tap->reported_state)
                        Expected state: {{$tap->expected_state}},
                    @endif
                    Current State: {{$tap->reported_state}}
                    @if ($tap->hasSchedule())
                                    {{$tap->getTurnOffDate()}}
                        @endif
                        </div>
                    {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                    <hr class="light"/>

                    {{ Form::model($tap, array('route' => array('taps.sendFakeResponse', $tap->id))) }}
                    {{ Form::select('reported_state', $onOrOffs, null, ['class' => 'form-control form-control-sm']) }}
                    {{ Form::submit('Pretend to respond to tap state change', ['class' => 'btn btn-debug']) }}
                    {{ Form::Close() }}

                    <hr class="light"/>
                    ({{$tap->uid}})
                </div>
                <div class="col-lg-3 mx-auto text-center">
                    <h3 class="section-heading text-white">Attached Sensors</h3>

                    @if  (count($sensors) > 0)
                        <h3>{{count($sensors)}} sensor{{(count($sensors) == 1 ? ' controls':'s control')}} this tap</h3>
                        @foreach ($sensors as $sensor)
                            <p>
                                    {{ $sensor->description }}
                                    @if (!$sensor->isActive())
                                        (inactive)
                                    @endif
                                    ({{$sensor->last_reading}}%)
                                <br />
                                <a href="{{$sensor->getUrl()}}" class="btn btn-default view">Show</a>
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
                    @endif
                </div>
            </div>
        </div>
    </section>


@endsection
