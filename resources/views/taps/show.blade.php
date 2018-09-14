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
                    <p class="text-faded"></p>
                    {{  Form::model($tap, array('route' => array('taps.changestatus', $tap->id))) }}
                    {{ Form::select('status', $statuses, null, ['class' => 'form-control']) }}

                    {{ $tap->status }}
                    {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}

                    {{ Form::model($tap, array('route' => array('taps.turntap', $tap->id))) }}
                    {{ Form::select('expected_state', $onOrOffs, null, ['class' => 'form-control']) }}

                    @if ($tap->expected_state != $tap->reported_state)
                        Expected state: {{$tap->expected_state}},
                    @endif
                    Current State: {{$tap->reported_state}}
                    {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                    ({{$tap->uid}})
                    <br/>
                    <h3 class="section-heading text-white">Controls</h3>

                    @if  (count($sensors) > 0)
                        <h3>{{count($sensors)}} sensor{{(count($sensors) == 1 ? ' controls':'s control')}} this
                            tap</h3>
                        @foreach ($sensors as $sensor)
                            <p><a href="{{$sensor->getUrl()}}" class="btn btn-default">{{ $sensor->description }}</a>
                            </p>
                        @endforeach
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
