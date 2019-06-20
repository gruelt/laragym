@extends('layouts.default')


@section('title')
    <H5><a href="/admin/equipes">Retour Liste</a>  </H5>
@stop

@section('content')
<div id="app">
    <br>



    <equipe-info :equipe_id="{{$equipe_id}}"></equipe-info>






</div>
@stop

@section('script')

@stop