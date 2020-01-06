@extends('layouts.default')


@section('title')
    <H5><a href="javascript:history.back()">Retour Liste</a>  </H5>

@stop

@section('content')
<div id="app">
    <br>



    <competitif-info :equipe_id="{{$equipe_id}}" :admin="true"></competitif-info>






</div>
@stop

@section('script')

@stop
