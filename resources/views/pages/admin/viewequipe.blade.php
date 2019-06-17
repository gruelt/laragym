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

    <div>
        <b-button v-b-modal.modal-1>Launch demo modal</b-button>

        <b-modal id="modal-1" title="BootstrapVue">
            <p class="my-4">Hello from modal!</p>
        </b-modal>
    </div>

</div>
@stop

@section('script')

@stop