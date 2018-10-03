@extends('layouts.material2')

@section('pagetitle')Your Taps @endsection
@section('headertitle')Your Taps @endsection
@section('pageColour', 'green')

@section('content')


    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title">All my taps</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover">
                    <thead class="text-success">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Current Status</th>
                    <th>&nbsp;</th>
                    </thead>
                    <tbody>
                    @foreach ($taps as $tap)
                        <tr>
                            <td>{{$tap->id}}</td>
                            <td> {{ $tap->description }}</td>
                            <td> {{$tap->status}}</td>
                            <td> <a href="{{$tap->getUrl()}}" class="btn btn-success">Show</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


              <a class="btn btn-success btn-xl " href="{{route('taps.add')}}">Register a new tap</a>

@endsection
