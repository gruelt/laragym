@extends('layouts.default')


@section('title')
    Mes Gymnastes @csrf
@stop

@section('content')
<div id="app">
    <br> {{json_encode($gym)}}
<gymnaste-info csrf="{{ csrf_token() }}" :gym="{{json_encode($gym)}}" :write=false :contact=false></gymnaste-info>
</div>
@stop

@section('script')

@stop