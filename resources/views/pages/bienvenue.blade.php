@extends('layouts.default')


@section('title')
    Bienvenue
@stop
@section('content')
    <div class="container">



                     <div class="card-body">
                <h5 class="card-title">
                    {{env('APP_NAME')}}</h5>
                <p class="card-text">Bienvenue</p>
                <a href="/about/" class="btn btn-primary">Hello</a>
            </div>
        </div>

    </div>

@stop
