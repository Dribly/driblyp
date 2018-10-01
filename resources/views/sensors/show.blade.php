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
                <div class="col-lg-12">

                    <p>(uid {{$sensor->uid}})</p>

                    <p><b>Last Reading:</b> {{$sensor->last_reading}}% at {{$sensor->last_signal_date}}</p><br/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <p><b>Status:</b><br/></p>
                    {{ Form::model($sensor, array('route' => array('sensors.changestatus', $sensor->id))) }}
                    {{ Form::select('status', $statuses, null, ['class' => 'form-control  form-control-sm']) }}

                    {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}

                    {{ Form::close() }}
                    </div></div></div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <p><b>Fake Values:</b><br/></p>
                    {{ Form::model($sensor, array('route' => array('sensors.sendFakeValue', $sensor->id))) }}
                    {{ Form::select('last_reading', $fakeValues, null, ['class' => 'form-control  form-control-sm ']) }}


                    {{ Form::submit('Send Fake Value', ['class' => 'btn btn-debug']) }}
                    {{ Form::Close() }}
                            </div></div></div>
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

                    <p>{{ ucfirst($tap->description) }}
                        ({{ $tap->reported_state }})<br/>
                        <a href="{{$tap->getUrl()}}"
                           class="btn btn-primary view">Show</a>
                        {{ Form::model($sensor, array('route' => array('sensors.detatch', $sensor->id))) }}
                        {{ Form::submit('Detatch', ['class' => 'btn btn-default ']) }}

                        {{Form::Close()}}</p>
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
                    </div></div></div>
        </div>
    </div>



@endsection
