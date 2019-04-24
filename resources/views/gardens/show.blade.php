@extends('layouts.material2')

@section('headertitle')Your Garden '{{$garden->description}}' @endsection
@section('pagetitle')Your Garden '{{$garden->description}}' @endsection
@section('pageColour', 'green')
@section('gardensNavHighlight', 'active')

@section('footer_js')
    <script type="text/javascript">const garden_id ={{(int)$garden->id}};</script>
@endsection
@section('content')
    <div class="row">
        <script src="https://maps.googleapis.com/maps/api/js?&v=3.exp&libraries=geometry,drawing,places"></script>
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
                            <h4 class="card-title">Garden Overview</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-2">
                                    <p><b class="text-success">Name:</b>
                                </div>
                                <div class="col-sm-10">
                                    {{$garden->name}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">

                    {{--                    <div id="map_container" data-tap-id="{{(int)$garden->id}}" data-csrf="{{ csrf_token() }}">I am a banaa</div--}}
                </div>

            </div>

        </div>
        <div class="col-sm-4">
            <div class="card mx-auto text-center">
                Weather: {{$weather->precip_type}} {{$weather->precip_intensity}} {{$weather->precip_probability}}

            </div>
        </div>
    </div>

@endsection
