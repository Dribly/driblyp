@extends('layouts.material')

@section('pagetitle')Your Taps @endsection
@section('headertitle')Your Taps @endsection

@section('content')


@foreach ($taps as $tap)
<p> {{ $tap->description }} {{ $tap->uid }} ({{$tap->status}}) <a href="{{$tap->getUrl()}}" class="btn btn-default">Show</a></p>
@endforeach
              <a class="btn btn-default btn-xl js-scroll-trigger btn-add" href="{{route('taps.add')}}">Register a new tap</a>

@endsection
