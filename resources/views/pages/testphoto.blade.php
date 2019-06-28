@extends('layouts.default')


@section('title')

@stop

@section('content')


<div id="app">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Test photo</div>

                    <div class="card-body">



                            @if ($errors->has('laphoto'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('laphoto') }}</strong>
                                    </span>
                            @endif

                            <form method="post" :action="'/gymnastes/1/photo'" enctype="multipart/form-data">
                                @csrf

                                <input id="laphoto" name="laphoto" type="file"  data-filename-placement="inside">

                                <input type="submit" class="btn btn-success" value="Envoyer">

                            </form>










                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@stop

@section('script')
<script>
    import {fr} from 'vuejs-datepicker/dist/locale'
</script>
@stop