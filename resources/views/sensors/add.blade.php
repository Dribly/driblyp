@extends('layouts.material2')

@section('headertitle')Add a sensor @endsection
@section('pagetitle')Add a sensor @endsection
@section('pageColour', 'orange')
@section('sensorsNavHighlight', 'active')

@section('content')
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
                        <div class="card-header card-header-warning">
                            <h4 class="card-title">Register your new Sensor</h4>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => 'sensors.add']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('UID', 'UID - You\'ll find this on the sticker', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::text('uid', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('name', 'Name (20 characters max)', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div><div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('description', 'Description - e.g. Front Garden, Flower Bed', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::text('description', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            {{ Form::submit('Register this Sensor', ['class' => 'btn-warning btn btn-xl pull-right']) }}
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
