<template>

    <div class="container-fluid d-flex h-100">





        <div class="card col-md-12">
            <!--<div class="col-md-12" id="problemes">-->

                <div v-for="probleme in gym.problemes " >
                    <div v-for="subprobleme in probleme " >
                        <div :class="'alert alert-dismissible alert-'+subprobleme.class" role="alert">
                            {{subprobleme.text}}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>
                </div>
            <hr>
            <!--</div>-->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-2 text-center">

                        <!--    On affiche les photos des comptes users - si aucun résultat on affiche une photo standard => Format préformaté en 120X160       -->

                        <div class="row text-center">
                            <div class="col-md-12 col-sm-2 text-center">

                            <img v-if="gym.photo" :src="gym.photo_url"  width="180" height="" alt="">
                            <img v-else src="/images/anonym.jpg" alt="" width="120" height="160">
                            </div>
                        </div>


                        <b-button v-b-modal.photoupload variant="success">Envoyer Une Photo</b-button>
                        <b-button v-if="admin" variant="success" :href="'/inscription/gymnastes/'+ gym.id+'/photo/take'">Prendre Une Photo</b-button>
                        <H3><span v-if="(admin)"><b-button :href="'/inscription/gymnastes/'+ gym.id+'/photo/crop'" variant="info">Recadrer</b-button></span></H3>




                        <b-modal id="photoupload" hide-footer>
                                <form method="post" :action="'/gymnastes/'+gym.id+'/photo'" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" :value="csrf">
                                    <input id="laphoto" name="laphoto" type="file"  data-filename-placement="inside">

                                    <input type="submit" class="btn btn-success" value="Envoyer">

                                </form>
                        </b-modal>











                    </div>





                    <div class="col-md-4 col-sm-12 text-left flex-fill">
                    <h2 class="card-title">
                        {{gym.nom}} {{gym.prenom}}
                    </h2>

                        <H3><span v-for="(niveau, id) in gym.niveaux_tab"><a :href="'/equipes/' + id " class="badge badge-primary">{{niveau}}</a>&nbsp;</span></H3>
                        <H3><span v-if="(admin)"><b-button v-b-modal.equipes variant="success">Gérer Equipes</b-button></span></H3>
                        <H3>{{gym.age}} ans</H3>
                        <h5>{{gym.date_naissance_fr}}</h5>
                        <H3>
                            <b-badge v-if="gym.genre.id === 1" variant="info">{{gym.genre.description}}</b-badge>
                            <b-badge v-if="gym.genre.id === 2" variant="warning">{{gym.genre.description}}</b-badge>
                        </H3>



                    </div>

                    <b-modal id="equipes" hide-header-close hide-footer title="Equipes du Gymnaste Pour la saison Actuelle">
                        <gymnaste-equipe :gymnaste_id="gym.id" :saison_id="saison_id"></gymnaste-equipe>
                        <b-button @click="hideModalTeam">Fermer</b-button>
                    </b-modal>









                    <div v-if="contact" class="col-md-4 col-sm-12 text-right">
                        <hr>
                        <h3>Responsable</h3>
                        {{gym.responsable.nom}} {{gym.responsable.prenom}} &nbsp;<span class="fa fa-user mr-3"></span><br>
                        {{gym.responsable.adresse}} {{gym.responsable.cp}} {{gym.responsable.ville}}&nbsp;<span class="fa fa-home mr-3"></span><br>
                        {{gym.responsable.email}} &nbsp;<span class="fa fa-envelope mr-3"></span><br>
                        0{{gym.responsable.telephone1}} &nbsp;<span class="fa fa-phone mr-3"></span><br>
                        0{{gym.responsable.telephone2}} &nbsp;<span class="fa fa-phone mr-3"></span><br>

                    </div>





                </div>



<hr>
                <!--debut admin-->
                <div class="row justify-content ">

                    <div v-if="admin" class="col-md-4 bg-warning align-self-center text-center  mh-100">
                        <h1 >Validations</h1>
                    </div>

                    <div class="col-md-8 text-right">

                            <span  v-if="admin && gym.problemes.paiement">
                                <b-button  variant="success" v-on:click="validpaiement(gym.tarif)">Valider le tarif de {{gym.tarif}}€</b-button>
                                <b-button  variant="success" v-on:click="validpaiement(gym.tarif-10)">Valider le tarif de {{gym.tarif-10}}€ (Réduction Familiale à partir du 2eme inscrit)</b-button>
                            </span>
                            <b-button v-else-if="admin && !gym.problemes.Groupe" v-on:click="annulpaiement()" variant="info">Annuler le tarif de </b-button>

                        <span  v-if="admin && gym.problemes.Groupe">
                            <b-button v-b-modal.equipes variant="success">Gérer Equipes</b-button>
                        </span>



                    </div>



                </div>








                <!--Fin admin -->
                <hr>

                <div class="row justify-content ">

                    <div class="col-md-4 bg-info align-self-center text-center  mh-100">
                        <h1 >Certificat Médical</h1>
                    </div>

                    <div class="col-md-8 text-right">
                        <!-- Si pas de certificat -->

                        <b-alert v-if="gym.certificat_medical == null" show variant="warning">Aucun Certificat Medical</b-alert>
                        <b-alert v-else show variant="info"><a :href="gym.certificat_medical_url"><i class="fas fa-file-alt"></i>&nbsp;Certificat Medical du {{gym.certificat_medical_date_fr}} valable jusqu'au {{gym.certificat_medical_fin_fr}} </a>



                            <b-badge v-if="(gym.certificat_medical_check == 0 && admin)" v-on:click="validcertif" variant="success">Valider le certificat</b-badge>
                            <b-badge v-if="gym.certificat_medical_check == 0" variant="warning">Attente Validation</b-badge>
                            <b-badge v-else variant="success">Vérifié</b-badge>

                        </b-alert>


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
                                <b-form-input id="certificat_medical_date" name="certificat_medical_date" type="date">



                                </b-form-input>

                                <input type="submit" class="btn btn-success" value="Envoyer">

                            </form>
                        </b-modal>
                    </div>



                </div>
<hr>

                <div class="row justify-content-center ">

                    <div class="col-md-4 bg-info text-center">

                        <h1>Saisons</h1>

                    </div>
                    <div class="col-md-8 col-sm-12 text-right">
                        <div class="list-group" >

                            <li class="list-inline" v-for="saison in gym.saisons ">
                                <b-button v-if="saison.pivot.complet ==1"  variant="success">
                                    {{saison.nom}} <b-badge variant="light">Complet</b-badge>
                                </b-button>
                                <b-button v-else  variant="info">
                                    {{saison.nom}} <b-badge variant="light">Préinscrit</b-badge>
                                    <span v-for="(probleme, index) in gym.problemes" variant="light" v-bind:key="probleme">

                                        <b-badge  v-for="(subprobleme, index2) in probleme" :variant="subprobleme.class" :key="subprobleme">{{subprobleme.text}}</b-badge>
                                    </span>
                                </b-button>

                            </li>


                        </div>
                        <b-button v-if="gym.reinscrit.statut ==0 && gym.reinscrit.saison !=0 "  :href="'/responsable/gymnaste/' + gym.id +'/reinscrire/'+ gym.reinscrit.saison.id" variant="warning">
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
            admin:{
                type: Boolean,
                default: false
            },
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
            },
            saison_id:{
                type: Number
            }



        },
        data() {
            return {

                update:"",

                filters: {
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                },






            }
        },
        methods: {

            updatedata: function () {
                 console.log('Mise à jour DB pour ' + this.idgym);
                 axios
                     .get('/api/admin/gymnastes/' + this.idgym)
                     .then(response => (this.gym = response.data))
                 ;


            },
            validcertif: function(){
                console.log('clic le certif ');
                axios
                    .get('/api/admin/gymnastes/' + this.gym.id+ '/certificatmedical/valid')

                ;
                //location.reload();
            },
            validpaiement: function(montant,saison_id){
                console.log('clic le paiement pour '+ montant + ' pour saison ' + this.saison_id);
                 axios
                     .get('/api/inscription/gymnastes/' + this.gym.id +  '/saison/'+ this.saison_id + '/paiement/valid/' + montant)
                     .then(response => (this.update= response.data));


                //location.reload();
            },
            annulpaiement: function(montant,saison_id){
                console.log('clic le paiement pour '+ montant + ' pour saison ' + this.saison_id);
                axios
                    .get('/api/inscription/gymnastes/' + this.gym.id +  '/saison/'+ this.saison_id + '/paiement/valid/' + 0)
                    .then(response => (this.update= response.data));;


                //location.reload();
            },

            getcurrent: function() {
                axios
                    .get('/api/saisons/actuelle')
                    .then(response => (this.saison_id = response.data));

            },
            hideModalTeam() {
                this.$root.$emit('bv::hide::modal', 'equipes', '#btnShow');
                location.reload();
            },

        },

        mounted() {
            this.getcurrent();
            //this.update();



        },

        watch: {
            update: function (val) {
                if(val != "")
                {
                    console.log('update forcée');
                    location.reload();
                }
            }
        }





    }

</script>
