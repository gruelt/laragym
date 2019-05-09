<template>

    <div class="container">


               <!-- 2nde card -->


        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-2 text-center">

                        <!--    On affiche les photos des comptes users - si aucun résultat on affiche une photo standard => Format préformaté en 120X160       -->

                        <div class="row text-center">
                            <div class="col-md-12 col-sm-2 text-center">
                                <h3>Photo</h3>
                            <img v-if="gym.photo" :src="gym.photo_url"  width="120" height="160" alt="">
                            <img v-else src="/images/anonym.jpg" alt="" width="120" height="160">
                            </div>
                        </div>


                        <b-button v-b-modal.photoupload variant="success">Envoyer Une Photo</b-button>




                        <b-modal id="photoupload" hide-footer>
                                <form method="post" :action="'/gymnastes/'+gym.id+'/photo'" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <input id="laphoto" name="laphoto" type="file"  data-filename-placement="inside">

                                    <input type="submit" class="btn btn-success" value="Envoyer">

                                </form>
                        </b-modal>




                        <hr>

                        <!-- Si pas de certificat -->
                        <h4>Certificat Médical</h4>
                        <b-alert v-if="gym.certificat_medical == null" show variant="warning">Aucun Certificat Medical</b-alert>
                        <b-alert v-else show variant="info"><a :href="gym.certificat_medical_url">Certificat Medical valable jusqu'au {{gym.certificat_medical_fin_fr}}</a></b-alert></b-alert>


                        <b-alert v-if="gym.certificat_medical_age >= 3" show variant="warning">Certificat dépassé</b-alert>


                        <b-button v-b-modal.certifupload variant="success">Envoyer Un certificat Medical</b-button>




                        <b-modal id="certifupload" hide-footer title="Envoyer un Certificat Médical">

                            <form method="post" :action="'/gymnastes/'+gym.id+'/certif'" enctype="multipart/form-data">
                                <input type="hidden" name="_token" :value="csrf">
                                <b-form-file
                                        v-model="file"
                                        :state="Boolean(file)"
                                        placeholder="Choisir un fichier"
                                        id="lecertif"
                                        name="lecertif"
                                        drop-placeholder="Drop file here..."
                                        accept=".png, .jpg, .pdf"

                                ></b-form-file>
                                <label for="certificat_medical_date">Date du Certificat Medical:</label>
                                <b-form-input id="certificat_medical_date" name="certificat_medical_date" type="date"></b-form-input>

                                <input type="submit" class="btn btn-success" value="Envoyer">

                            </form>
                        </b-modal>





                    </div>





                    <div class="col-md-4 col-sm-2 text-left">
                    <h2 class="card-title">
                        {{gym.nom}} {{gym.prenom}}
                    </h2>
                        <H3><span v-for="(niveau, id) in gym.niveaux_tab"><a :href="'/equipes/' + id " class="badge badge-primary">{{niveau}}</a>&nbsp;</span></H3>
                        <H3>{{gym.age}} ans</H3>
                        <h5>{{gym.date_naissance_fr}}</h5>
                        <H3>
                            <b-badge v-if="gym.genre.id === 1" variant="info">{{gym.genre.description}}</b-badge>
                            <b-badge v-if="gym.genre.id === 2" variant="warning">{{gym.genre.description}}</b-badge>
                        </H3>



                    </div>









                    <div v-if="contact" class="col-md-4 col-sm-2 text-right">
                        {{gym.responsable.nom}} {{gym.responsable.prenom}} &nbsp;<span class="fa fa-user mr-3"></span><br>
                        {{gym.responsable.adresse}} {{gym.responsable.cp}} {{gym.responsable.ville}}&nbsp;<span class="fa fa-home mr-3"></span><br>
                        {{gym.responsable.email}} &nbsp;<span class="fa fa-envelope mr-3"></span><br>
                        0{{gym.responsable.telephone1}} &nbsp;<span class="fa fa-phone mr-3"></span><br>
                        0{{gym.responsable.telephone2}} &nbsp;<span class="fa fa-phone mr-3"></span><br>

                    </div>





                </div>


                <hr>




                <div class="row justify-content-center">

                    <div class="col-md-12">

                        <h1>Saisons</h1>
                        <div class="list-group" >

                            <li class="list-inline" v-for="saison in gym.saisons ">
                                <b-button v-if="saison.pivot.complet ==1"  variant="success">
                                    {{saison.nom}} <b-badge variant="light">Complet</b-badge>
                                </b-button>
                                <b-button v-else  variant="info">
                                    {{saison.nom}} <b-badge variant="light">Préinscrit</b-badge>
                                </b-button>

                            </li>



                        </div>
                        <b-button v-if="gym.reinscrit.statut ==0 && gym.reinscrit.saison !=0 "  variant="warning">
                            + Re-inscrire pour {{gym.reinscrit.saison.nom}}
                        </b-button>
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
            write:{
                type: Boolean,
                default:false
            },
            contact:{
                type: Boolean,
                default: true
            }


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
