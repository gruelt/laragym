@extends('layouts.default')


@section('title')
    Liste des Adhérents
@stop

@section('content')

    @if(isset($quick))
    Rapide <gymnaste-table-quick :quick="true"></gymnaste-table-quick>
    @else
        <gymnaste-table></gymnaste-table>
    @endif



@stop

@section('script')

@stop