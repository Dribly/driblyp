@extends('layouts.bootstrap')

@section ('headertitle')Welcome to your dashboard@endsection
@section ('pagetitle')Dribly Dashboard ashboard@endsection
@endsection

@section('content')

    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">DASHBOARD</h2>
            <hr class="light">
            <p class="text-faded">Just attach the tap using hoselock connectors to your system, and use an online timer for free. Get a sensor (subscription required) and we will keep the garden watered. Monitor on our Dribbly app and your garden will be wet all year.</p>
            <a class="btn btn-default btn-xl js-scroll-trigger" href="#services">Get Started!</a>
          </div>
        </div>
      </div>
    </section>

      
@endsection
