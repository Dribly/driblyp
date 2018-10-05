@extends('layouts.material2')

@section('headertitle')Water Sensor: {{$sensor->description}} @endsection
@section('pagetitle')Water Sensor: {{$sensor->description}} @endsection
@section('pageColour', 'orange')
@section('sensorsNavHighlight', 'active')

@section('content')

    <div class="row">
        <div class="form-group col-lg-8">
            <div class="row">
                <div class="col-lg-12">
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
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Sensor Overview</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2"><b class="text-warning">ID:</b></div>
                                <div class="col-sm-10"> {{$sensor->uid}}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"><b class="text-warning">First registered:</b></div>
                                <div class="col-sm-10"> {{date('d M Y',strToTime($sensor->created_at))}}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"><b class="text-warning">Name:</b></div>
                                <div class="col-sm-10"> {{$sensor->name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"><b class="text-warning">Description:</b></div>
                                <div class="col-sm-10"> {{$sensor->description}}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"><b class="text-warning">Last Reading:</b></div>
                                <div class="col-sm-10">{{$sensor->last_reading}}%
                                    at {{date('d M H:i',strToTime($sensor->last_signal_date))}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <b class="text-warning">Battery Strength:</b></div>
                                <div class="col-sm-10"> {{$sensor->last_battery_level}}%
                                    at {{date('d M H:i',strToTime($sensor->last_signal_date))}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <p><b class="text-warning">Dryness Threshold:</b></div>
                                <div class="col-sm-10"> {{$sensor->threshold}}%</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Disable / enable</h4>
                        </div>
                        <div class="card-body">
                            <p>If your sensor is inactive, we will ignore any signals from it</p>
                            {{ Form::model($sensor, array('route' => array('sensors.changestatus', $sensor->id))) }}
                            {{ Form::select('status', $statuses, null, ['class' => 'form-control  form-control-sm']) }}

                            {{ Form::submit('Save Status', ['class' => 'btn btn-warning pull-right']) }}

                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title">Debug Use Only</h4>
                        </div>
                        <div class="card-body">
                            <p><b>Fake Values:</b><br/></p>
                            {{ Form::model($sensor, array('route' => array('sensors.sendFakeValue', $sensor->id))) }}
                            {{ Form::select('last_reading', $fakeValues, null, ['class' => 'form-control  form-control-sm ']) }}


                            {{ Form::submit('Send Fake Value', ['class' => 'btn btn-debug pull-right']) }}
                            {{ Form::Close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mx-auto text-center">
            <div class="card">
                <div class="card-header card-header-success">
                    <h4 class="card-title">Attached Taps</h4>
                </div>
                <div class="card-body">

                    @if  (count($taps) > 0)
                        <h3>{{ count($taps)}} tap{{(count($taps) == 1 ? '':'s')}} controlled by this sensor</h3>
                        @foreach ($taps as $tap)
                            <div class="row">
                                <div class="col-sm-6 pull-right">

                                    {{ ucfirst($tap->name) }}
                                    ({{ $tap->reported_state }})
                                </div>
                                <div class="col-sm-6">
                                    {{--<a href="{{$tap->getUrl()}}" rel="tooltip"--}}
                                    {{--class="btn btn-warning btn-link btn-sm">Show</a>--}}
                                    <a href="{{$tap->getUrl()}}" rel="tooltip" title=""
                                       class="btn btn-success btn-link btn-sm"
                                       data-original-title="Show">
                                        <i class="material-icons">visibility</i>
                                    </a>
                                    {{ Form::model($sensor, array('route' => array('sensors.detach', $sensor->id), 'class'=>'button-form')) }}
                                    {{--{{ Form::submit('Detach', ['class' => 'btn btn-icon btn-round ']) }}--}}
                                    <button type="submit" rel="tooltip" title=""
                                            class="btn btn-success btn-link btn-sm"
                                            data-original-title="Detach">
                                        <i class="material-icons">delete</i>
                                        <div class="ripple-container"></div>
                                    </button>
                                    {{Form::hidden('tap_id', $tap->id)}}
                                    {{Form::Close()}}
                                </div>
                            </div>
                        @endforeach
                    @else
                        There are no taps attached to this sensor yet. Choose one below to begin controlling it with this sensor
                    @endif

                    @if  (count($taps)== 0 && count($allTaps) > 0)
                        {{ Form::model($sensor, array('route' => array('sensors.connectToTap', $sensor->id))) }}
                        {{ Form::select('tap_id', $allTaps, null, ['class' => 'form-control']) }}

                        {{ Form::submit('Link sensor to this Tap', ['class' => 'btn btn-success pull-right']) }}
                        {{ Form::Close() }}
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection
