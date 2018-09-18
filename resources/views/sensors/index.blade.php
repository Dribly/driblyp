@extends('layouts.bootstrap')

@section('headertitle')Sensors @endsection
@section('pagetitle')Sensors @endsection

@section('content')

    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">Sensors</h2>
            <hr class="light">
            <p class="text-faded"></p>
@foreach ($sensors as $sensor)
<p>{{$sensor->id}}: {{ $sensor->description }} {{ $sensor->uid }}  <a href="{{$sensor->getUrl()}}" class="btn btn-default">Show</a></p>
@endforeach
              <a class="btn btn-default btn-xl js-scroll-trigger btn-add" href="{{route('sensors.add')}}">Register a new sensor</a>
          </div>
        </div>
      </div>
    </section>

      
@endsection
