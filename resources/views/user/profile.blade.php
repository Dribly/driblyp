@extends('layouts.material2')

@section('headertitle') Your Profile @endsection
@section('pagetitle') Your Profile @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @foreach (['danger', 'warning', 'success', 'info'] as $key)
                @if(Session::has($key))
                    <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                @endif
            @endforeach
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                <h2>Your details</h2>

                {{Form::model($user, array('route' => array('user.update', $user->id)))}}

                <div class="form-group">
                    <table>
                        <tr>
                            <td>{{ Form::label('firstname', 'Your First name', ['class' => 'control-label']) }}</td>
                            <td>{{ Form::text('firstname', null, ['class' => 'form-control']) }}</td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('lastname', 'Your Last or Family Name', ['class' => 'control-label']) }}</td>
                            <td>{{ Form::text('lastname', null, ['class' => 'form-control']) }}</td>
                        </tr>
                        <tr>
                            <td>{{ Form::label('email', 'Your email address', ['class' => 'control-label']) }}</td>
                            <td>{{ Form::text('email', null, ['class' => 'form-control']) }}</td>
                        </tr>

                    </table>
                </div>
                {{ Form::hidden('id') }}
                {{ Form::submit('Change your details', ['class' => 'btn-primary btn btn-xl ']) }}
            </div>
        </div>
    </div>
@endsection
