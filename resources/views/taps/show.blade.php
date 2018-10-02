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
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Tap overview</h4>
                        </div>
                        <div class="card-body">
                            ({{$tap->uid}})


                            {{--<p><b>ID:</b> - {{$sensor->uid}}</p>--}}
                            {{--<p><b>First registered:</b>b> - {{date('d M Y',strToTime($sensor->created_at))}}</p>--}}

                            {{--<p><b>Last Reading:</b> {{$sensor->last_reading}}%--}}
                            {{--at {{date('d M H:i',strToTime($sensor->last_signal_date))}}</p>--}}
                            {{--<p><b>Battery Strength:</b> {{$sensor->last_battery_level}}%--}}
                            {{--at {{date('d M H:i',strToTime($sensor->last_signal_date))}}</p>--}}
                            {{--<p><b>Dryness Threshold:</b> {{$sensor->threshold}}%</p>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Disable / enable</h4>
                        </div>
                        <div class="card-body">
                            <p>If your sensor is inactive, we will ignore any signals from it</p>
                            {{ Form::model($tap, array('route' => array('taps.changestatus', $tap->id))) }}
                            {{ Form::select('status', $statuses, null, ['class' => 'form-control form-control-sm']) }}

                            {{ $tap->status }}
                            {{ Form::submit('Save Status', ['class' => 'btn btn-success']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Control this tap</h4>
                        </div>
                        <div class="card-body ">
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
                            {{ Form::submit('Save Status', ['class' => 'btn btn-success']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header card-header-error">
                            <h4 class="card-title">Debug use only</h4>
                        </div>
                        <div class="card-body">
                            {{ Form::model($tap, array('route' => array('taps.sendFakeResponse', $tap->id))) }}
                            {{ Form::select('reported_state', $onOrOffs, null, ['class' => 'form-control form-control-sm']) }}
                            {{ Form::submit('Pretend to respond to tap state change', ['class' => 'btn btn-debug']) }}
                            {{ Form::Close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card mx-auto text-center">
                <div class="card-body">
                    <div class="tab-content">
                        <h3 class="section-heading "><b>Attached Sensors</b></h3>

                        @if  (count($sensors) > 0)
                            <h3>{{count($sensors)}} sensor{{(count($sensors) == 1 ? ' controls':'s control')}} this
                                tap</h3>
                            @foreach ($sensors as $sensor)
                                <div class="row">
                                    <div class="col-sm-6 pull-right">
                                        {{ $sensor->description }}
                                        @if (!$sensor->isActive())
                                            (inactive)
                                        @endif
                                        ({{$sensor->last_reading}}%)
                                    </div>
                                    <div class="col-sm-6">

                                        {{--<a href="{{$tap->getUrl()}}" rel="tooltip"--}}
                                        {{--class="btn btn-warning btn-link btn-sm">Show</a>--}}
                                        <a href="{{$sensor->getUrl()}}" rel="tooltip" title=""
                                           class="btn btn-success btn-link btn-sm"
                                           data-original-title="Show">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        {{ Form::model($sensor, array('route' => array('taps.detach', $tap->id), 'class'=>'button-form')) }}
                                        {{--                                    {{ Form::submit('Detach', ['class' => 'btn btn-icon btn-round ']) }}--}}
                                        <button type="submit" rel="tooltip" title=""
                                                class="btn btn-success btn-link btn-sm"
                                                data-original-title="Detach">
                                            <i class="material-icons">delete</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                        {{Form::hidden('sensor_id', $sensor->id)}}
                                        {{Form::Close()}}
                                        {{--                                    <a href="{{$sensor->getUrl()}}" class="btn btn-primary view">Show</a>--}}
                                    </div>
                                </div>
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
        </div>
    </div>

@endsection
