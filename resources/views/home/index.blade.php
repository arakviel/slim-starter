@extends('layouts.app')

@section('header')
    <nav class="menu">
        Майбутня навігація
    </nav>
@endsection

@section('content')
    <h1>Hello from HOME blade</h1>
    <p>{{ $hello }}</p>

    {{--    <ol>
            @foreach($users as $user)
                <li>{{ $user->getLogin() }}</li>
            @endforeach
        </ol>

        <p>{{ $post->getTitle() }}</p>
        <p>{{ $post->getBody() }}</p>--}}

@endsection