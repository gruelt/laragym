@extends('layouts.vuetify')


@section('title')
    Bienvenue
@stop
@section('content')
    @if (Route::has('login'))






        <v-content>
            @auth
                <a href="{{ url('/home') }}">Homeaaaaaaaaaaaaaaaaaaaa</a>
            @else
                <a href="{{ route('login') }}">Se Connecter</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Enregistrer un nouveau compte</a>
                @endif
            @endauth
        </v-content>





    @endif

@stop



