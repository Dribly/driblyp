@extends('layouts.material2')
@section('pagetitle', 'Register a new account')
@section('registerNavHighlight', 'active')
@section('content')
    <!-- resources/views/auth/register.blade.php -->
    @if ($errors->any())
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-12 mx-auto text-center">
                        @foreach ($errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
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
                            <h4 class="card-title">Register your details</h4>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => 'register']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::label('firstname', 'First Name', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::text('firstname', old('firstname'), ['class' => 'form-control']) }}

                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('lastname', 'Last Name', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::text('lastname', old('lastname'), ['class' => 'form-control']) }}

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    {{ Form::label('email', 'Email Address', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::email('email', old('email'), ['class' => 'form-control']) }}

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    {{ Form::label('password', 'Password', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::password('password', ['class' => 'form-control']) }}

                                </div>
                                <div class="col-md-6">
                                    {{ Form::label('password_confirmation', 'Password Confirmation', ['class' => 'bmd-label-floating']) }}
                                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}

                                </div>
                            </div>
                            {{ Form::Submit('Register', ['class'=>'btn btn-primary pull-right'])}}
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
