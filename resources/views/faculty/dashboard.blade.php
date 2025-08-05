
@extends('layouts.app')

@section('title', 'Faculty Dashboard')

@section('styles')
<style>
    h1{
        color: blue;
        text-align: center;
        font-size: 4em;
    }
</style>

@endsection


@section('content')


<h1>DASHBOARD FOR FACULTY</h1>
<h1>Welcome {{ Auth::user()->name }}</h1>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
@endsection
