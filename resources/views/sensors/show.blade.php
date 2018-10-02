@extends('layouts.material2')

@section('headertitle')Water Sensor: {{$sensor->description}} @endsection
@section('pagetitle')Water Sensor: {{$sensor->description}} @endsection
@section('pageColour', 'orange')

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
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Sensor overview</h4>
                        </div>
                        <div class="card-body">

                            <p><b>ID:</b> - {{$sensor->uid}}</p>
                            <p><b>First registered:</b>b> - {{date('d M Y',strToTime($sensor->created_at))}}</p>

                            <p><b>Last Reading:</b> {{$sensor->last_reading}}%
                                at {{date('d M H:i',strToTime($sensor->last_signal_date))}}</p>
                            <p><b>Battery Strength:</b> {{$sensor->last_battery_level}}%
                                at {{date('d M H:i',strToTime($sensor->last_signal_date))}}</p>
                            <p><b>Dryness Threshold:</b> {{$sensor->threshold}}%</p>
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

                            {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}

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


                            {{ Form::submit('Send Fake Value', ['class' => 'btn btn-debug']) }}
                            {{ Form::Close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mx-auto text-center">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <h3 class="section-heading "><b>Attached Taps</b></h3>

                        @if  (count($taps) > 0)
                            <h3>{{ count($taps)}} tap{{(count($taps) == 1 ? '':'s')}} controlled by this sensor</h3>
                            @foreach ($taps as $tap)
                                <div class="row">
                                    <div class="col-sm-6 pull-right">

                                        {{ ucfirst($tap->description) }}
                                        ({{ $tap->reported_state }})
                                    </div>
                                    <div class="col-sm-6">
                                        {{--<a href="{{$tap->getUrl()}}" rel="tooltip"--}}
                                        {{--class="btn btn-warning btn-link btn-sm">Show</a>--}}
                                        <a href="{{$tap->getUrl()}}" rel="tooltip" title=""
                                           class="btn btn-warning btn-link btn-sm"
                                           data-original-title="Show">
                                            <i class="material-icons">visibility</i>
                                        </a>
                                        {{ Form::model($sensor, array('route' => array('sensors.detach', $sensor->id), 'class'=>'button-form')) }}
                                        {{--{{ Form::submit('Detach', ['class' => 'btn btn-icon btn-round ']) }}--}}
                                        <button type="submit" rel="tooltip" title=""
                                                class="btn btn-warning btn-link btn-sm"
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
                            There are no taps attached to this sensor yet
                        @endif

                        @if  (count($taps)== 0 && count($allTaps) > 0)
                            {{ Form::model($sensor, array('route' => array('sensors.connectToTap', $sensor->id))) }}
                            {{ Form::select('tap_id', $allTaps, null, ['class' => 'form-control']) }}

                            {{ Form::submit('Link sensor to this Tap', ['class' => 'mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored mdl-color-text--white']) }}
                            {{ Form::Close() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
