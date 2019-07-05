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



                                @if (session()->has('user'))
                                        <h3 >Gérer mes inscrits</h3>

                                        <span class="subheading">.</span>

                                        <v-divider class="my-3"></v-divider>



                                        <a href="/responsable/gymnastes" class="btn btn-primary">Voir/Ajouter un Gymnaste</a>

                                        <v-btn
                                                class="mx-0"
                                                color="primary"
                                                large
                                        >

                                        </v-btn>
                                    <hr>
                                 @endif

                                    @if (session()->has('admin'))
                                        <h3 >Administrateur</h3>

                                        <span class="subheading">.</span>

                                        <v-divider class="my-3"></v-divider>



                                        <a href="/admin/gymnastes/quick" class="btn btn-primary"><i class="fas fa-shipping-fast"></i> Voir les Gymnastes Mode Rapide</a>
                                        <a href="/admin/gymnastes/quick" class="btn btn-primary">Voir les Gymnastes </a>


                                    @endif

                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-jumbotron>
            </v-app>



        </div>



        </div>

    </div>

@stop
