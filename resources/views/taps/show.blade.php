@extends('layouts.bootstrap')

@section('headertitle')Taps @endsection
@section('pagetitle')Your Taps @endsection

@section('content')
    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
            <a class=" text-white" href="{{route('taps.index', [])}}">&laquo; Back to Taps </a>
        </div>
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">Taps</h2>
            <hr class="light">
            <p class="text-faded"></p>
            {{$tap->description}}
            {{  Form::model($tap, array('route' => array('taps.changestatus', $tap->id))) }}
            {{ Form::select('status', $statuses, null, ['class' => 'form-control']) }}

                {{$tap->status}}
            {{ Form::submit('Save Status', ['class' => 'btn btn-primary']) }}

{{ Form::close() }}
            ({{$tap->uid}})
            <br />
            <h3>Controls</h3>

            @if  (count($sensorMap) > 0)
            <h3>{{count($sensorMap)}} sensor{{(count($sensorMap) == 1 ? ' is':'s are')}} controlled by this tap</h3>
            @foreach ($sensorMap as $sensorMap)
            @php
            $sensor = $sensors[$sensorMap->sensor_id]
            @endphp
            <p> <a href="{{$sensor->getUrl()}}" class="btn btn-default">{{ $sensor->description }} ({{$sensorMap->status}})</a></p>
@endforeach
@endif

            @if  (count($allSensors) > 0)
                {{  Form::model($tap, array('route' => array('taps.connectToSensor', $tap->id))) }}
                {{ Form::select('sensor_id', $allSensors, null, ['class' => 'form-control']) }}

                {{ Form::submit('Control Tap with this Sensor', ['class' => 'btn btn-primary']) }}
                {{Form::Close()}}
            @endif            
          </div>
        </div>
      </div>
    </section>

      
@endsection
