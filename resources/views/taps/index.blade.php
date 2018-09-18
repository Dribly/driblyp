@extends('layouts.bootstrap')

@section('pagetitle')Your Taps @endsection
@section('headertitle')Your Taps @endsection

@section('content')

    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">Taps</h2>
            <hr class="light">
            <p class="text-faded"></p>
@foreach ($taps as $tap)
<p> {{ $tap->description }} {{ $tap->uid }} ({{$tap->status}}) <a href="{{$tap->getUrl()}}" class="btn btn-default">Show</a></p>
@endforeach
              <a class="btn btn-default btn-xl js-scroll-trigger btn-add" href="{{route('taps.add')}}">Register a new tap</a>
          </div>
        </div>
      </div>
    </section>

      
@endsection
