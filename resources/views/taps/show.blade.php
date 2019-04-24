@extends('layouts.material2')

@section('headertitle')Your Tap '{{$tap->description}}' @endsection
@section('pagetitle')Your Tap '{{$tap->description}}' @endsection
@section('pageColour', 'green')
@section('tapsNavHighlight', 'active')

@section('footer_js')
    <script type="text/javascript">const tap_id ={{(int)$tap->id}};</script>
    <script src="{{ mix('/js/myjs.js') }}"></script>
@endsection
@section('content')
    <style type="text/css">
        span.tap_off, span.tap_on {
            width: 6px;
            display: inline-block;

        }

        span.tap_off {
            color: red;
        }

        span.tap_on {
            color: green;
        }
    </style>
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
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Tap Overview</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <p><b class="text-success">Name:</b>
                                </div>
                                <div class="col-sm-10">
                                    {{$tap->name}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p><b class="text-success">Description:</b>
                                </div>
                                <div class="col-sm-10">
                                    {{$tap->description}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p><b class="text-success">UID:</b>
                                </div>
                                <div class="col-sm-10">
                                    {{$tap->uid}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    This tap is currently: <b>{{ucfirst($tap->reported_state)}}</b> and
                                    <b>{{ucfirst($tap->status)}}</b>
                                    @if ($tap->hasSchedule())
                                        {{$tap->getTurnOffDate()}}
                                    @endif
                                    @if ($tap->expected_state != $tap->reported_state)
                                        we have sent a message to turn it: {{$tap->expected_state}},
                                    @endif

                                    @if ($tap->isBlockedByTimer())
                                        The tap will not turn on due to a timer block, you can adjust this below
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Disable / enable</h4>
                        </div>
                        <div class="card-body">
                            <p>If your tap is inactive, we will not send any signals to it. This takes precedence over
                                all other signals, so even if the timer is on,
                                and the sensors report dryness, the tap will not turn on. This tap is currently
                                <b>{{ucfirst($tap->status)}}</b></p>
                            {{ Form::model($tap, array('route' => array('taps.changestatus', $tap->id))) }}
                            {{ Form::select('status', $statuses, null, ['class' => 'form-control form-control-sm']) }}

                            {{ Form::submit('Save Status', ['class' => 'btn btn-success pull-right']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Manual Control</h4>
                        </div>
                        <div class="card-body ">
                            {{ Form::model($tap, array('route' => array('taps.turntap', $tap->id))) }}
                            <div class="row">
                                <div class="col-md-12">
                                    This overrides the timer blocks, but does not override the Disable / Enable switch.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    The Tap should
                                    be {{ Form::select('expected_state', $onOrOffs, null, ['class' => 'form-control form-control-sm']) }}
                                </div>
                                <div class="col-md-6">
                                    for {{ Form::select('off_for_minutes', $timeLengths, null, ['class' => 'form-control form-control-sm']) }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::submit('Save Status', ['class' => 'btn btn-success pull-right']) }}
                                </div>
                                {{ Form::close() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">


                    <div id="clock_container" data-tap-id="{{(int)$tap->id}}" data-csrf="{{ csrf_token() }}"></div>

                </div>

            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">Debug use only</h4>
                        </div>
                        <div class="card-body">
                            <div class="md-form">
                                <input placeholder="Selected time" type="text" id="input_starttime"
                                       class="form-control timepicker">
                                <label for="input_starttime">Light version, 12hours</label>
                            </div>
                            {{ Form::model($tap, array('route' => array('taps.sendFakeResponse', $tap->id))) }}
                            {{ Form::select('off_for_minutes', $timeLengths, null, ['class' => 'form-control form-control-sm']) }}
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
                <div class="card-header card-header-warning">
                    <h4 class="card-title">Attached Sensors</h4>
                </div>
                <div class="card-body">
                    <div class="tab-content">

                        @if  (count($sensors) > 0)
                            <h3>{{count($sensors)}} sensor{{(count($sensors) == 1 ? ' controls':'s control')}} this
                                tap</h3>
                            @foreach ($sensors as $sensor)
                                <div class="row">
                                    <div class="col-sm-6 pull-right">
                                        {{ $sensor->name }}
                                        @if (!$sensor->isActive())
                                            (inactive)
                                        @endif
                                        ({{$sensor->last_reading}}%)
                                    </div>
                                    <div class="col-sm-6">

                                        {{--<a href="{{$tap->getUrl()}}" rel="tooltip"--}}
                                        {{--class="btn btn-warning btn-link btn-sm">Show</a>--}}
                                        <a href="{{$sensor->getUrl()}}" rel="tooltip" title=""
                                           class="btn btn-warning btn-link btn-sm"
                                           data-original-title="Show">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        {{ Form::model($sensor, array('route' => array('taps.detach', $tap->id), 'class'=>'button-form')) }}
                                        {{--                                    {{ Form::submit('Detach', ['class' => 'btn btn-icon btn-round ']) }}--}}
                                        <button type="submit" rel="tooltip" title=""
                                                class="btn btn-warning btn-link btn-sm"
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
                            There are no sensors connected to this tap yet. Choose one below to begin controlling this
                            tap with it
                        @endif

                        @if  (count($allSensors) > 0)
                            <h4>Add another sensor</h4>
                            {{ Form::model($tap, array('route' => array('taps.connectToSensor', $tap->id))) }}
                            {{ Form::select('sensor_id', $allSensors, null, ['class' => 'form-control']) }}

                            {{ Form::submit('Control Tap with this Sensor', ['class' => 'btn btn-warn']) }}
                            {{Form::Close()}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
