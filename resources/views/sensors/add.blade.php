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
            <p class="text-faded">You can register your sensor here, just enter the ID on the side of the device, and a helpful label to help you identify your sensor</p>

{{ Form::open([
    'route' => 'sensors.add'
]) }}

<div class="form-group">
    <table>
        <tr>
            <td>{{ Form::label('label', 'Your Label (e.g. Front Garden, Flower Bed):', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('label', null, ['class' => 'form-control']) }}</td>
       </tr>
        <tr>
            <td>{{ Form::label('ID', 'ID (from the side of the sensor):', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('id', null, ['class' => 'form-control']) }}</td>
        </tr>

    </table>
</div>

{{ Form::submit('Register this Sensor', ['class' => 'btn-default btn btn-xl ']) }}

{{ Form::close() }}
          </div>
        </div>
      </div>
    </section>

      
@endsection
