@extends('layouts.app')

@section('content')

<h1>タスク一覧</h1>

    @if (Auth::check())
    {{ Auth::user()->name }}
 
    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasks</h1>
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>
    @endif
   

@endsection