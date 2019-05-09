@extends('layouts.default')


@section('title')
    Mes Gymnastes @csrf
@stop

@section('content')
<div id="app">
    <br>
<gymnaste-info csrf="{{ csrf_token() }}" :gym="{{json_encode($gym)}}" :write=false :contact=false></gymnaste-info>
    {{json_encode($gym)}}
</div>
@stop

@section('script')

@stop