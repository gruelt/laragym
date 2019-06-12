@extends('layouts.default')

@section('script')
    {{--<script src="/js/jpeg_camera_with_dependencies.min.js" type="text/javascript"></script>
    <script src="/js/jquery.cropit.js" type="text/javascript"></script>--}}
    <script type='text/javascript'>
        $(function() {

            const constraints = {video: true};
            const api_url = "/gymnastes/{{$gym_id}}/photo64";

            const screenshotButton = document.querySelector('#screenshot-button');
            const uploadButton = document.querySelector('#screenshot-upload-btn');
            const img = document.querySelector('#screenshot2 img');
            const video = document.querySelector('#screenshot2 video');

            const canvas = document.createElement('canvas');

            navigator.mediaDevices.getUserMedia(constraints).
            then(handleSuccess).catch(handleError);



            screenshotButton.onclick = video.onclick = function() {
                uploadButton.disabled = false;
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                // Other browsers will fall back to image/png
                img.src = canvas.toDataURL('image/png');
                img.width = video.videoWidth/2;
                img.height = video.videoHeight/2;
            };

            function handleSuccess(stream) {
                screenshotButton.disabled = false;
                video.srcObject = stream;
            }
            uploadButton.onclick = function() {


                upload(api_url, "{{ csrf_token() }}", img.src);

            }

            function handleError(error) {
                console.error('Error: ', error);
            }

            function upload(api_url, csrf_token, data)
            {
                $.post( api_url, { '_token': csrf_token, 'laphoto': data } )
                    .done(function( data ) {
                        window.history.back();
                    });

            }



        });

    </script>

    <style type=text/css>

        button, input, #loader {
            /*display: none;*/
        }

        input {
            width: 300px;
        }

        #camera {
            display: inline-block;
            background-color: #eee;
            width: 640px;
            height: 480px;
            margin: 0.5em;
        }

        #camera .placeholder {
            padding: 0.5em;
        }

        #snapshots {
            height: 150px;
            margin: 0.5em 0;
            padding: 3px;

            border: 1px solid #aaa;

            white-space: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
        }

        #snapshots canvas, #snapshots img {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;

            height: 100%;
            margin-left: 3px;
            border: 3px solid transparent;
        }

        #snapshots .selected {
            border: 3px solid #000;
        }

        button, #upload_status, #upload_result, #loader {
            margin: 0.5em;
        }
        /* Translucent background image */
        .cropit-preview-background {
            opacity: .2;
        }

        /*
         * If the slider or anything else is covered by the background image,
         * use relative or absolute position on it
         */
        input.cropit-image-zoom-input {
            position: relative;
        }

        /* Limit the background image by adding overflow: hidden */
        #image-cropper {
            overflow: hidden;
        }
        .inline {
            display: inline;
        }
    </style>
@stop



@section ('title')
    Prise de photo pour {{$gym_id}}
@stop

@section('content')
    <div id="app">
    <input type="hidden" id="api_url" value="/sesame/porteurs/photo/{{$gym_id}}/u"><br>



    <div id="screenshot2" style="text-align:center;">
        <video class="videostream" autoplay=""></video>


        </p><p><button id="screenshot-button" disabled="" class='btn btn-info'><i class="fa fa-camera" ></i> Prendre une photo</button>
            <button id="screenshot-upload-btn" class='btn btn-info' disabled=""><i class="fa fa-photo"></i> Valider la photo</button></p>
        <img id="screenshot-img">

    </div>

    </div>



@stop
