@extends('layouts.bootstrap')

@section('headertitle')404 @endsection
@section('pagetitle')404 not found @endsection

@section('content')
    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">404 - Error</h2>
            <hr class="light">
            <p class="text-faded">404 means that we are sorry, but the thing you are trying to find can't be found. Please either retype your address, or contact us if you think it's our fault</p>
            
            @if (Auth::guest())
            <a class="btn btn-default btn-xl js-scroll-trigger" href="/">Back to homepage</a>
            @else
            <a class="btn btn-default btn-xl js-scroll-trigger" href="{{route('users.dashboard')}}">Back to dashboard</a>
            @endif
            <br />
          </div>
        </div>
      </div>
    </section>

      
@endsection
