@extends('layouts.app')

@section('header')
    <nav class="menu">
        Майбутня навігація
    </nav>
@endsection

@section('content')
    <h1>Hello from HOME blade</h1>
    <p>{{ $hello }}</p>
@endsection