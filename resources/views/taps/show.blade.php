@extends('layouts.bootstrap')

@section('headertitle')Taps @endsection
@section('pagetitle')Your Taps @endsection

@section('content')

    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">Taps</h2>
            <hr class="light">
            <p class="text-faded"></p>
            <a class="btn btn-default btn-xl js-scroll-trigger" href="{{route('taps.add')}}">Register a new tap</a>
            <br />
            {{$tap->description}} ({{$tap->uid}})
          </div>
        </div>
      </div>
    </section>

      
@endsection
