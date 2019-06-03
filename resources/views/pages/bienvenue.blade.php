@extends('layouts.default')


@section('title')
    Bienvenue
@stop
@section('content')
    <div class="container">

        <div id="app">



            <v-app id="inspire">
                <v-jumbotron>
                    <v-container fill-height>
                        <v-layout align-center>
                            <v-flex>
                                <h3 class="display-3">FJEP Gymnastique</h3>

                                <span class="subheading">.</span>

                                <v-divider class="my-3"></v-divider>



                                <a href="/responsable/gymnastes" class="btn btn-primary">Voir/Ajouter un Gymnaste</a>

                                <v-btn
                                        class="mx-0"
                                        color="primary"
                                        large
                                >

                                </v-btn>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-jumbotron>
            </v-app>



        </div>



        </div>

    </div>

@stop
