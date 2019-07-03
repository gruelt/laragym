@extends('layouts.default')


@section('title')
    Liste des Adhérents
@stop

@section('content')

    @if(isset($quick))
    Mode Turbo <gymnaste-table :quick="true"></gymnaste-table>
    @else
        <gymnaste-table></gymnaste-table>
    @endif



@stop

@section('script')

@stop