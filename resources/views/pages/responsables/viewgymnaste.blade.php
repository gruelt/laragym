@extends('layouts.default')


@section('title')
    <H5><a href="javascript:history.back()">Retour Liste</a>  </H5>
@stop

@section('content')
<div id="app">
    <br>
<gymnaste-info csrf="{{ csrf_token() }}" :gym="{{json_encode($gym)}}" :write=false :contact=false></gymnaste-info>

    @if(env('APP_DEBUG')==true)
        {{json_encode($gym)}}
        @endif
</div>
@stop

@section('script')

@stop