@extends('layouts.material2')

@section('headertitle')Add a sensor @endsection
@section('pagetitle')Add a sensor @endsection

@section('content')
    @foreach (['danger', 'warning', 'success', 'info'] as $key)
        @if(Session::has($key))
            <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
        @endif
    @endforeach
    <hr class="light">
    <p class="text-faded">You can register your sensor here, just enter the ID on the side of the device, and a helpful
        label to help you identify your sensor</p>

    {{ Form::open([
        'route' => 'sensors.add'
    ]) }}

    <div class="form-group">
        <table>
            <tr>
                <td>{{ Form::label('description', 'Your Description of the location of the sensor (e.g. Front Garden, Flower Bed):', ['class' => 'control-label']) }}</td>
                <td>{{ Form::text('description', null, ['class' => 'form-control']) }}</td>
            </tr>
            <tr>
                <td>{{ Form::label('UID', 'UID (from the side of the sensor):', ['class' => 'control-label']) }}</td>
                <td>{{ Form::text('uid', null, ['class' => 'form-control']) }}</td>
            </tr>

        </table>
    </div>

    {{ Form::submit('Register this Sensor', ['class' => 'btn-default btn btn-xl ']) }}

    {{ Form::close() }}


@endsection
