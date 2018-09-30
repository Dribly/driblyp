@extends('layouts.material')

@section('headertitle')Add a Tap @endsection
@section('pagetitle')Add a Tap @endsection

@section('content')

    @foreach (['danger', 'warning', 'success', 'info'] as $key)
        @if(Session::has($key))
            <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
        @endif
    @endforeach
    <hr class="light">
    <p class="text-faded">You can register your tap here, just enter the ID on the side of the device, and a helpful
        label to help you identify your tap</p>

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



@endsection
