@extends('layouts.material2')

@section('headertitle')Add a Tap @endsection
@section('pagetitle')Add a Tap @endsection
@section('pageColour', 'green')
@section('tapsNavHighlight', 'active')

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
                            <h4 class="card-title">Register your new Tap</h4>
                        </div>
                        <div class="card-body">
                            {{ Form::open(['route' => 'taps.add']) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('UID', 'UID - You\'ll find this on the sticker', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::text('uid', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('name', 'Choose a name (20 characters max)', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('garden', 'Which garden is this tap for?', ['class' => 'bmd-label']) }}
                                        {{ Form::select('garden', $gardens, null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group bmd-form-group">
                                        {{ Form::label('description', 'Description - e.g. Front Tap, Kitchen Tap', ['class' => 'bmd-label-floating']) }}
                                        {{ Form::text('description', null, ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            {{ Form::submit('Register this Tap', ['class' => 'btn-success btn btn-xl pull-right']) }}
                            {{ Form::close() }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
