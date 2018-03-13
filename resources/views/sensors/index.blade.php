@extends('layouts.bootstrap')

@section('headertitle')Add a sensor @endsection
@section('pagetitle')Add a sensor @endsection

@section('content')

    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">Add Sensor</h2>
            <hr class="light">
            <p class="text-faded"></p>
            <a class="btn btn-default btn-xl js-scroll-trigger" href="{{route('sensors.add')}}">Register a new sensor</a>
@foreach ($sensors as $sensor)
<p>{{$sensor->id}}: <a href="{{$sensor->getUrl()}}" class="btn btn-default">{{ $sensor->description }} {{ $sensor->uid }}</a></p>
@endforeach
          </div>
        </div>
      </div>
    </section>

      
@endsection
