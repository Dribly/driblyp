@extends('layouts.material2')

@section('headertitle')Tell us about your garden @endsection
@section('pagetitle')Tell us about your garden @endsection
@section('pageColour', 'green')
@section('gardensNavHighlight', 'active')

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
                        <div class="card-header card-header-success">
                            <h4 class="card-title">Tell us about your Garden</h4>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => 'gardens.add']) }}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('name', 'Name (20 characters max)', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('location', 'Pinpoint your garden on this map', ['class' => 'bmd-label-floating']) }}
                                        GOOGLE MAPS HERE
                                        <p><b>This allows us to correctly predict the weather in your area</b>
                                    </div>
                                </div>
                            </div>
                            {{ Form::submit('Save this garden', ['class' => 'btn-warning btn btn-xl pull-right btn-success']) }}
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
