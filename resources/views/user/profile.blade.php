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
    <div class="card col-md-8">
        <div class="card-header card-header-primary">
            <h4 class="card-title">Edit Profile</h4>
            <p class="card-category">Complete your profile</p>
        </div>
        <div class="card-body">
            <div class="tab-content">

                {{Form::model($user, array('route' => array('user.update', $user->id)))}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                            {{ Form::label('firstname', 'Your First name', ['class' => 'bmd-label-floating']) }}
                            {{ Form::text('firstname', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group bmd-form-group">
                            {{ Form::label('lastname', 'Your Last or Family Name', ['class' => 'bmd-label-floating']) }}
                            {{ Form::text('lastname', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        {{ Form::label('email', 'Your email address', ['class' => 'bmd-label-floating']) }}
                        {{ Form::text('email', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                {{ Form::hidden('id') }}
                {{ Form::submit('Change your details', ['class' => 'btn btn-primary pull-right']) }}
            </div>
        </div>
    </div>
@endsection
