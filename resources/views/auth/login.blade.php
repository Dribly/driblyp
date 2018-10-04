@extends('layouts.material2')
@section('pagetitle', 'Log In')
@section('loginNavHighlight', 'active')

@section('content')

<!-- resources/views/auth/login.blade.php -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-12 mx-auto text-center">
                @foreach (['danger', 'warning', 'success', 'info'] as $key)
                    @if(Session::has($key))
                        <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
                    @endif
                @endforeach
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title">Sign in</h4>
                    </div>
                    <div class="card-body">
                            {{ Form::open(['route' => 'login']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('email', 'Your Email Address', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::text('email', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('password', 'Your Password', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::password('password', ['class' => ' form-control']) }}
                                    </div>
                                </div>
                            </div>
                        {{Form::Submit('Sign in', ['class'=>'pull-right btn btn-primary'])}}
                            {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
