@extends('layouts.default')


@section('title')
    <H5><a href="javascript:history.back()">Retour Liste</a>  </H5>
@stop

@section('content')
<div id="app">
    <br>
<gymnaste-info csrf="{{ csrf_token() }}" :idgym="{{$gym['id']}}"  :gym="{{json_encode($gym)}}"   :write=false :contact=true :admin=true operateur="{{Auth::user()->id}}"></gymnaste-info>

    @if(env('APP_DEBUG')==true)


        <hr><hr>
{{--        {{json_encode($gym)}}--}}

        @endif
</div>
@stop

@section('script')

@stop
