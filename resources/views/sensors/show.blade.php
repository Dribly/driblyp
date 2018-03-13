@extends('layouts.bootstrap')

@section('headertitle')Sensors @endsection
@section('pagetitle')Your Sensors @endsection

@section('content')
    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">Show Sensor</h2>
            <hr class="light">
            <p class="text-faded"></p>
            <a class="btn btn-default btn-xl js-scroll-trigger" href="{{route('sensors.add')}}">Register a new sensor</a>
            <br />
            {{$sensor->description}} ({{$sensor->uid}})
          </div>
        </div>
      </div>
    </section>

      
@endsection
