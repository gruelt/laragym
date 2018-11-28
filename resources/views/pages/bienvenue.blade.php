@extends('layouts.default')


@section('title')
    Bienvenue
@stop
@section('content')
    <div class="container">

        <i class="fab fa-phoenix-framework fa-10x "></i> Phoenix Admin v1.0 <i class="fab fa-phoenix-squadron fa-10x "></i>

        <div class="card m-5" style="width: 20rem;">

                     <div class="card-body">
                <h5 class="card-title">
                    {{env('APP_NAME')}}</h5>
                <p class="card-text">Bienvenue</p>
                <a href="https://services-numeriques.emse.fr/service/sesame" class="btn btn-primary">Fiche de service</a>
            </div>
        </div>

    </div>

@stop
