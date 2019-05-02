@extends('layouts.default')


@section('title')
    Mes Gymnastes
@stop

@section('content')
<div id="app">
    {{json_encode($gym)}}
<gymnaste-info :gym="{{json_encode($gym)}}"></gymnaste-info>
</div>
@stop

@section('script')

@stop