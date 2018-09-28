@extends('layouts.bootstrap')

@section('headertitle')Sensors @endsection
@section('pagetitle')Your Sensors @endsection

@section('content')
    <section class="bg-primary" id="about">
        <div class="container">
            <div class="row">
                <a class=" text-white" href="{{route('taps.index', [])}}">&laquo; Back to Taps </a>
            </div>
            <div class="row">
                <div class="col-lg-9 mx-auto text-center form-inline">
                    @foreach (['danger', 'warning', 'success', 'info'] as $key)
                        @if(Session::has($key))
                            <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                        @endif
                    @endforeach

                    <div class="form-group col-lg-9">
                        <h2 class="section-heading text-white">Water Sensor: {{$sensor->description}}</h2>
                        <hr class="light"/>
                    </div>
                    <div class="form-group col-lg-9">

                        (uid {{$sensor->uid}})
                    </div>
                    <div class="form-group col-lg-9">
                        <p><b>Last Reading:</b> {{$sensor->last_reading}}% at {{$sensor->last_signal_date}}</p><br/>
                    </div>
                    <div class="form-group col-lg-9">
                        <p><b>Status:</b><br/>
                        {{ Form::model($sensor, array('route' => array('sensors.changestatus', $sensor->id))) }}
                        {{ Form::select('status', $statuses, null, ['class' => 'form-control  form-control-sm']) }}

                        {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}

                        {{ Form::close() }}
                    </div>
                    <hr class="light"/>
                    <div class="form-group col-lg-9">
                        {{ Form::model($sensor, array('route' => array('sensors.sendFakeValue', $sensor->id))) }}
                        {{ Form::select('last_reading', $fakeValues, null, ['class' => 'form-control  form-control-sm ']) }}


                        {{ Form::submit('Send Fake Value', ['class' => 'btn btn-debug']) }}
                        {{ Form::Close() }}
                    </div>
                </div>
                <div class="col-lg-2 mx-auto text-center">
                    <h3 class="section-heading text-white">Attached Taps</h3>

                    @if  (count($taps) > 0)
                        <h3>{{ count($taps)}} tap{{(count($taps) == 1 ? '':'s')}} controlled by this sensor</h3>
                        @foreach ($taps as $tap)

                            <p>{{ ucfirst($tap->description) }}
                                ({{ $tap->reported_state }})<br/>
                                <a href="{{$tap->getUrl()}}" class="btn btn-default view">Show</a>
                                {{ Form::model($sensor, array('route' => array('sensors.detatch', $sensor->id))) }}
                                {{ Form::submit('Detatch', ['class' => 'btn btn-default']) }}

                            {{Form::Close()}}</p>
                        @endforeach
                    @else
                        There are no taps attached to this sensor yet
                    @endif

                    @if  (count($taps)== 0 && count($allTaps) > 0)
                        {{ Form::model($sensor, array('route' => array('sensors.connectToTap', $sensor->id))) }}
                        {{ Form::select('tap_id', $allTaps, null, ['class' => 'form-control']) }}

                        {{ Form::submit('Link sensor to this Tap', ['class' => 'btn btn-primary']) }}
                        {{ Form::Close() }}
                    @endif


                </div>
            </div>
        </div>
    </section>


@endsection
