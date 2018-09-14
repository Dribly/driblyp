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
                <div class="col-lg-8 mx-auto text-center">
                    @foreach (['danger', 'warning', 'success', 'info'] as $key)
                        @if(Session::has($key))
                            <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                        @endif
                    @endforeach
                    <h2 class="section-heading text-white">Water Sensor: {{$sensor->description}}</h2>
                    <hr class="light"/>
                    <p class="text-faded"></p>

                    ({{$sensor->uid}})
                    {{  Form::model($sensor, array('route' => array('sensors.changestatus', $sensor->id))) }}
                    {{ Form::select('status', $statuses, null, ['class' => 'form-control']) }}

                    <p>{{$sensor->status}}</p>
                    <p><b>Last Reading:</b> {{$sensor->last_reading}}% at {{$sensor->last_signal_date}}</p>
                    {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}

                    {{ Form::close() }}
                    <hr class="light"/>

                    {{ Form::model($sensor, array('route' => array('sensors.sendFakeValue', $sensor->id))) }}
                    {{ Form::select('value', $fakeValues, null, ['class' => 'form-control']) }}


                    {{ Form::submit('Send Fake Value', ['class' => 'btn btn-primary']) }}
                    {{ Form::Close() }}

                    <hr class="light"/>
                    @if  (count($taps) > 0)
                        <h3>{{count($taps)}} tap{{(count($taps) == 1 ? '':'s')}} controlled by this sensor</h3>
                        @foreach ($taps as $tap)

                            <p><a href="{{$tap->getUrl()}}" class="btn btn-default">{{ $tap->description }}
                                </a></p>
                        @endforeach
                    @endif

                    @if  (count($taps)== 0 && count($allTaps) > 0)
                        {{ Form::model($sensor, array('route' => array('sensors.connectToTap', $sensor->id))) }}
                        {{ Form::select('tap_id', $allTaps, null, ['class' => 'form-control']) }}

                        {{ Form::submit('Link sensor to this Tap', ['class' => 'btn btn-primary']) }}
                        {{Form::Close()}}
                    @endif


                </div>
            </div>
        </div>
    </section>


@endsection
