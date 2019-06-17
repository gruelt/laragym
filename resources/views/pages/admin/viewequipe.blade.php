@extends('layouts.default')


@section('title')
    <H5><a href="/admin/gymnastes">Retour Liste</a>  </H5>
@stop

@section('content')
<div id="app">
    <br>
{{$equipe_id}}
    @if(env('APP_DEBUG')==true)
        {{json_encode($equipe_id)}}
        @endif
</div>
@stop

@section('script')

@stop