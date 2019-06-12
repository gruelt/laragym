<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Se Connecter</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Enregistrer un nouveau compte</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                @if(isset($errors) && !empty($errors->first()))
                    <div class="row col-lg-12">
                        <div class="alert alert-danger">
                            <span>{!! $errors->first() !!}</span>
                        </div>
                    </div>
                @endif
                <div class="title m-b-md">
                    {{--FJEP Gymnastique--}}
                    <div id="app">
                    <b-img src="/images/full.png" fluid alt="Responsive image"></b-img>
                    </div>
                </div>
                <div class="subtitle m-b-md">
                    Saint Just - Saint Rambert
                </div>

                <div class="links">
                    <a href="http://fjepgym.fr">Site</a>
                    <a href="https://www.facebook.com/FjepGym/">Facebook</a>
                    <a href="https://www.facebook.com/pages/category/Nonprofit-Organization/Gymnastique-Ufolep-Loire-1024528947672542/">UFOLEP Loire</a>

                </div>
            </div>
        </div>

        <script type="text/javascript" src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
