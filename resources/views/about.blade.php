@extends('layouts.default')


@section('title')

@stop
@section('content')
    <div class="container">

        <div id="app">



            <v-app id="inspire">
                <v-jumbotron>
                    <v-container fill-height>
                        <v-layout align-center>
                            <v-flex>
                                <h3 class="display-3">A propos</h3>

                                <span class="subheading">.</span>

                                <v-divider class="my-3"></v-divider>



                                <a href="/home" class="btn btn-primary">Accueil</a>

                                <v-btn
                                        class="mx-0"
                                        color="primary"
                                        large
                                >

                                </v-btn><br>

                                <b>Version du {{ Carbon\Carbon::parse(trim(exec('git log -n1 --pretty=%ci HEAD')))->formatLocalized(' %d/%m/%Y %H:%I:%S') }}
                                </b>
                                    <br>
                                <table>
                                @for ($i = 0; $i < 30; $i++)
                                        <tr><td>{{exec("git log -$i --pretty=format:'%h - %s (%ci)' --abbrev-commit")}}</td></tr>
                                    @endfor
                                </table>

                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-jumbotron>
            </v-app>



        </div>



    </div>

    </div>

@stop
