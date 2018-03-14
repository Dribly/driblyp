@extends('layouts.bootstrap')
@section('pagetitle')Register a new account
Log In
@endsection
@section('content')
<!-- resources/views/auth/register.blade.php -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<section>
<form method="POST" action="/register">
    {!! csrf_field() !!}

    <div>
        First Name
        <input type="text" name="firstname" value="{{ old('firstname') }}">
    </div>
    <div>
        Last Name
        <input type="text" name="lastname" value="{{ old('lastname') }}">
    </div>

    <div>
        Email
        <input type="email" name="email" value="{{ old('email') }}">
    </div>

    <div>
        Password
        <input type="password" name="password">
    </div>

    <div>
        Confirm Password
        <input type="password" name="password_confirmation">
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>
</section>
      
@endsection
