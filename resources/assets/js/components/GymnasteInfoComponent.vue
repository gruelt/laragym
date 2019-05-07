<template>

    <div class="container">


        <div class="card card-inverse" style="background-color: #f5f5f5; border-color: #BFC0C0;padding:5px;">
            <div class="card-block">
                <div class="row">
                    <div class="col-md-4 col-sm-2 text-center">

                        <!--    On affiche les photos des comptes users - si aucun résultat on affiche une photo standard => Format préformaté en 120X160       -->

                        <img v-if="gym.photo" :src="gym.photo_url"  width="120" height="160" alt="">
                        <img v-else src="/images/anonym.jpg" alt="" width="120" height="160">


                        <!--<a :href="'/responsable/gymnastes/'+ gym.id +'/photo'" type="button" class="btn btn-success btn-block">Envoyer une photo</a>-->
                        <form method="post" :action="'/gymnastes/'+gym.id+'/photo'" enctype="multipart/form-data">
                            <input type="hidden" name="_token" :value="csrf">
                            <input id="laphoto" name="laphoto" type="file"  data-filename-placement="inside">







                            <input type="submit" class="btn btn-success" value="Envoyer">
                        </form>

                    </div>
                    <div class="col-md-8 col-sm-8">

                        <!--    Name / givenname       -->
                        <h2 class="card-title">
                            {{gym.nom}} {{gym.prenom}}
                        </h2>

                        <!--    Mail       -->
                        <p  class="card-text">
                            <span class="fa fa-envelope mr-3"></span>
                            <span v-for="(niveau, id) in gym.niveaux_tab"><a :href="'/equipes/' + id " class="badge badge-primary">{{niveau}}</a>&nbsp;</span>
                        </p>

                        <!--&lt; Date de Naissance-->
                        <p class="card-text">
                            <span class="fab fa-fort-awesome mr-3"></span>
                            <span >{{gym.date_naissance_fr}}</span>
                        </p>

                        <!--    Service       -->
                        <p class="card-text">
                            <span class="fa fa-envelope mr-3"></span>
                            <span >{{gym.age}} ans</span>
                        </p>


                        <p class="card-text">
                            <span class="fa fa-home mr-3"></span>
                            <span >{{gym.commentaire}}</span>
                        </p>

                        <!--    Saisons d'inscription       -->
                        <p  class="card-text">
                            <span class="fa fa-envelope mr-3"></span>
                            <span v-for="(saison, id) in gym.saisons"><a :href="'/saison/' + id " class="badge badge-primary">{{saison.nom}} </a>&nbsp;</span>
                        </p>

                        <!--&lt;!&ndash;    Profil(s) Phoenix       &ndash;&gt;-->
                        <!--<p class="card-text">-->
                            <!--<span class="fa fa-home mr-3"></span>-->
                            <!--<span v-for="(profile) in json.profiles"><a v-bind:href="'/admin/profile/'+profile.id" class="btn btn-info" role="button">{{profile.name}}</a>&nbsp;</span>-->
                        <!--</p>-->

                        <br><br>

                    </div>

                    <!--    Etat du compte       -->
                    <div class="col-md-2 col-sm-2 text-center">
                        <span class="badge badge-success badge-pill float-md-right"> </span>
                    </div>

                </div>
            </div>
        </div>


        <hr>





    </div>
</template>

<script>

    export default {


        props: {
            idgym: {
                type: Number

            },
            gym:{
                type: Object
            },
            csrf:{
                type: String
            },
            debug:
                {
                    type: Boolean,
                    default: false
                },


        },
        data() {
            return {
                // gym: {
                //     id: '',
                //     nom: '',
                //     prenom: '',
                //     niveaux: '',
                //     date_naissance: ''
                // }






            }
        },
        methods: {

            update: function () {
                console.log('Mise à jour DB pour ' + this.idgym);
                axios
                    .get('/api/responsable/gymnastes/' + this.idgym)
                    .then(response => (this.gym = response.data))
                ;


            }
        },

        mounted() {
            //this.update();


        },



    }

</script>
