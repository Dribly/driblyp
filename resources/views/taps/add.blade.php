@extends('layouts.bootstrap')

@section('headertitle')Add a Tap @endsection
@section('pagetitle')Add a Tap @endsection

@section('content')

    <section class="bg-primary" id="about">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
            <h2 class="section-heading text-white">Add a Tap</h2>
@foreach (['danger', 'warning', 'success', 'info'] as $key)
 @if(Session::has($key))
     <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
 @endif
@endforeach
            <hr class="light">
            <p class="text-faded">You can register your tap here, just enter the ID on the side of the device, and a helpful label to help you identify your tap</p>

{{ Form::open([
    'route' => 'taps.add'
]) }}

<div class="form-group">
    <table>
        <tr>
            <td>{{ Form::label('description', 'Your description of the location of the Tap (e.g. Front Tap, Kitchen Tap):', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('description', null, ['class' => 'form-control']) }}</td>
       </tr>
        <tr>
            <td>{{ Form::label('UID', 'UID (from the side of the tap):', ['class' => 'control-label']) }}</td>
            <td>{{ Form::text('uid', null, ['class' => 'form-control']) }}</td>
        </tr>

    </table>
</div>

{{ Form::submit('Register this Tap', ['class' => 'btn-default btn btn-xl ']) }}

{{ Form::close() }}
          </div>
        </div>
      </div>
    </section>

      
@endsection
