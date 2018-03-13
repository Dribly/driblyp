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
            <a class="btn btn-default btn-xl js-scroll-trigger" href="/sensors/add">Register a new sensor!</a>
            <table>
                <tr><td>Sensor 1 (fake)</td><td><a class="btn btn-default" href="/sensors/1">Lookie</a></td></tr>
                <tr><td>Sensor 2 (fake)</td><td><a class="btn btn-default" href="/sensors/2">Lookie</a></td></tr>
            </table>
          </div>
        </div>
      </div>
    </section>

      
@endsection
