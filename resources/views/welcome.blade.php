@extends('layouts.default')


@section('title')
    Bienvenue
@stop
@section('content')
    @if (Route::has('login'))







            @auth
                <a href="{{ url('/home') }}">Homeaaaaaaaaaaaaaaaaaaaa</a>
            @else
                <a href="{{ route('login') }}">Se Connecter</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Enregistrer un nouveau compte</a>
                @endif
            @endauth






    @endif

@stop



