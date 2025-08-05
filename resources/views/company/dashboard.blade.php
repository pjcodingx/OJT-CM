@extends('layouts.app')


@section('title', 'Company Dashboard')


@section('content')

<h1>WELCOME TO COMPANY DASHBOARD</h1>
<h1>Welcome {{ Auth::user()->name }}</h1>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>

@endsection
