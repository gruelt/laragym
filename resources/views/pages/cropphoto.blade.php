@extends('layouts.default')

@section('script')

    <script>

        const api_url = "/gymnastes/{{$gym->id}}/photo64";

        const uploadButton = document.querySelector('#screenshot-upload-btn');
        uploadButton.onclick = function() {

            const canvas = this.$refs.clipper.clip();//call component's clip method
            var photo64 = canvas.toDataURL("image/jpg", 1);

            upload(api_url, "{{ csrf_token() }}", photo64);

        }

        function upload(api_url, csrf_token, data)
        {

            $.post( api_url, { '_token': csrf_token, 'laphoto': data } )
                .done(function( data ) {
                    //window.history.back();
                });

        }
    </script>

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
    Prise de photo pour {{ $gym->prenom }} {{ $gym->nom }}
@stop

@section('content')
    <div id="app">
        <div class="clip">

            <div class="row">
                <div class="col-6">
                    <div id="overlay"><img src='/images/photo_template.png'></div>
                    <clipper-fixed src="/storage/{{$gym->photo}}"
                                   class="sesame_clipper"
                                   :min-scale=0.6
                                   ref="clipper"></clipper-fixed>


                    <button @click="getResult" class="btn btn-primary">clip image</button>
                </div>





                <div class="col-4">
                    <div>Resultat:</div>
                    <img class="result" :src="resultURL" alt="">
                    <form method="POST" action="/gymnastes/{{$gym->id}}/photo64/redirect" accept-charset="UTF-8"><input name="_token" type="hidden" value="{{csrf_token()}}">
                        <input id="hidden_base64" name="laphoto" type="hidden">
                        <input class="btn btn-success" id="valid" type="submit" value="valider">
                        <b-button  variant="success" v-on:click="validpaiement(gym.tarif)">Couic !</b-button>
                        <button id="screenshot-upload-btn" class='btn btn-info' ><i class="fa fa-photo"></i> GOajax</button></p>

                </div>
            </div>
        </div>
    </div>


@stop
