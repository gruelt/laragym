@extends('layouts.default')


@section('title')
    <H5><a href="javascript:history.back()">Retour Liste</a>  </H5>

@stop

@section('content')
<div id="app">
    <br>



    <user-info :user_id="{{$user_id}}" :admin="true"></user-info>






</div>
@stop

@section('script')

@stop