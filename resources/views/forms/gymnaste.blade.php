@extends('layouts.default')


@section('title')

@stop

@section('content')


<div id="app">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Gymnaste à Inscrire</div>

                    <div class="card-body">
                        <form method="POST" action="/responsable/gymnastes/add">
                            @csrf


                            <div class="form-group row">
                                <label for="nom" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                                <div class="col-md-6">
                                    <input id="nom" type="text" class="form-control{{ $errors->has('nom') ? ' is-invalid' : '' }}" name="nom" value="{{ old('nom') }}" required autofocus>

                                    @if ($errors->has('nom'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                                <div class="col-md-6">
                                    <input id="prenom" type="text" class="form-control{{ $errors->has('prenom') ? ' is-invalid' : '' }}" name="prenom" value="{{ old('prenom') }}" required autofocus>

                                    @if ($errors->has('prenom'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('prenom') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="genre" class="col-md-4 col-form-label text-md-right">{{ __('Genre') }}</label>

                                <div class="col-md-6">

                                    <select id=genre class="form-control{{ $errors->has('genre') ? ' is-invalid' : '' }}" name="genre">
                                        <option value="2">Feminin</option>
                                        <option value="1">Masculin</option>

                                    </select>

                                    @if ($errors->has('genre'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('genre') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <datepicker></datepicker>





                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Valider') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@stop

@section('script')

@stop