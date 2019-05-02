@extends('layouts.material2')

@section('pagetitle')Your Gardens @endsection
@section('headertitle')Your Gardens @endsection
@section('pageColour', 'green')
@section('gardensNavHighlight', 'active')

@section('content')

    <div class="col-lg-8 col-md-12">
        <div class="card">
            <div class="card-header card-header-success">
                <h4 class="card-title">All my gardens</h4>
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

                    @foreach ($gardens as $garden)
                        <tr>
                            <td>{{$garden->id}}</td>
                            <td> {{ $garden->name }}</td>
                            <td> {{$garden->status}}</td>
                            <td> <a href="{{$garden->getUrl()}}" class="btn btn-success">Show</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


              <a class="btn btn-success btn-xl " href="{{route('gardens.add')}}">Register a new garden</a>

@endsection
