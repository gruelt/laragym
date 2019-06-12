@extends('layouts.default')

@section('script')



    <style type=text/css>

        .sesame_clipper {
            width: 100%;
            max-width: 700px;
            opacity: .90;

        }

        .clip {
            position: absolute;
            top: 100px;
            left: 400px;
            width: 100%;

        }


        #overlay {
            position: absolute;
            top: 190px;
            left: 240px;

        }

        .area {
            width: 240px !important;
            height: 320px !important;
        }
    </style>

@stop

@section ('title')
    Prise de photo pour {{ $porteur->prenom }} {{ $porteur->nom }}
@stop

@section('content')
    <div id="app">
        <div class="clip">

            <div class="row">
                <div class="col-6">
                    <div id="overlay"><img src='/images/photo_template.png'></div>
                    <clipper-fixed src="/storage/photos/{{$porteur->id}}.jpg"
                                   class="sesame_clipper"
                                   :min-scale=0.6
                                   ref="clipper"></clipper-fixed>


                    <button @click="getResult" class="btn btn-primary">clip image</button>
                </div>





                <div class="col-4">
                    <div>Resultat:</div>
                    <img class="result" :src="resultURL" alt="">
                    {{ Form::open(array('route' => array('uploadCrop', $porteur->id)))}}
                    {{ Form::hidden('cropPhoto', null, ['id' => 'hidden_base64']) }}
                    {{ Form::submit('valider', ['class' => 'btn btn-success', 'id' => 'valid']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


@stop
