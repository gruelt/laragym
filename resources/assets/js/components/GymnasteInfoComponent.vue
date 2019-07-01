<template>
<div>




    <b-container fluid class="bv-example-row">

        <b-row>
            <b-col>
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
            </b-col>
        </b-row>



        <b-row>

            <!--Photo-->
            <b-col sm="12" lg="2">
                <b-card tag="photo"
                        title="Photo"
                        class="mb-12 text-center"
                >
                    <b-card-text>
                        <b-img thumbnail fluid :src="gym.photo_url" alt="ID" width="180"></b-img>
                        <b-button v-b-modal.photoupload variant="success">Envoyer</b-button>
                        <b-button v-if="admin" variant="success"
                                  :href="'/inscription/gymnastes/'+ gym.id+'/photo/take'">Webcam
                        </b-button>
                        <H3><span v-if="(admin)"><b-button :href="'/inscription/gymnastes/'+ gym.id+'/photo/crop'"
                                                           variant="info">Recadrer</b-button></span></H3>


                    </b-card-text>


                </b-card>

                <b-card tag="certificat"
                        title="Certificat Medical"
                        class="mb-12 text-center"
                >
                    <b-card-text>

                        <b-alert v-if="gym.certificat_medical == null" show variant="warning">Aucun Certificat Medical</b-alert>
                        <b-alert v-else show variant="info"><a :href="gym.certificat_medical_url"><i class="fas fa-file-alt"></i>&nbsp;Certificat Medical du {{gym.certificat_medical_date_fr}} valable jusqu'au {{gym.certificat_medical_fin_fr}} </a>



                            <b-badge v-if="(gym.certificat_medical_check == 0 && admin)" v-on:click="validcertif" variant="success">Valider le certificat</b-badge>
                            <b-badge v-if="gym.certificat_medical_check == 0" variant="warning">Attente Validation</b-badge>
                            <b-badge v-else variant="success">Vérifié</b-badge>

                        </b-alert>


                        <b-alert v-if="gym.certificat_medical_age >= 3" show variant="warning">Certificat dépassé</b-alert>


                        <h5><modify-modal :display="gym.certificat_medical_date_fr" :admin="admin" type="date" field="certificat_medical_date" :id="gym.id" model="Gymnaste" :value="gym.certificat_medical_date"></modify-modal></h5>

                        <b-button v-b-modal.certifupload variant="success">Envoyer</b-button>




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

                    </b-card-text>


                </b-card>



            </b-col>




            <!--Fin Photo-->

            <!-- Fiche synthese -->
            <b-col lg="3" xs="12">







                        <b-card tag="article"

                                class="mb-12 "
                        >
                            <b-card-text>
                                <h2 >
                                    <modify-modal :admin="admin" field="nom" :id="gym.id" model="Gymnaste" :value="gym.nom"></modify-modal>
                                </h2>


                                <h2><modify-modal :admin="admin" field="prenom" :id="gym.id" model="Gymnaste" :value="gym.prenom"></modify-modal></h2>

                                <H3>{{gym.age}} ans</H3>

                                <h5><modify-modal :display="gym.date_naissance_fr" :admin="admin" type="date" field="date_naissance" :id="gym.id" model="Gymnaste" :value="gym.date_naissance"></modify-modal></h5>
                                <H3>
                                    <b-badge v-if="gym.genre.id === 1" variant="info">{{gym.genre.description}}</b-badge>
                                    <b-badge v-if="gym.genre.id === 2" variant="warning">{{gym.genre.description}}</b-badge>
                                </H3>

                                <span v-if="gym.commentaire"><b-badge variant="danger">{{gym.commentaire}}</b-badge></span>

                            </b-card-text>


                        </b-card>






                <b-card tag="article"

                        class="mb-12 "
                >
                    <b-card-text>
                        <h5 >
                            Groupes / Niveaux
                        </h5>

                        <H3><span v-for="(niveau, id) in gym.niveaux_tab"><a :href="'/equipes/' + id " class="badge badge-primary">{{niveau}}</a>&nbsp;</span></H3>
                        <H3><span v-if="(admin)"><b-button v-b-modal.equipes variant="success">Gérer Equipes</b-button></span></H3>
                        <b-modal id="equipes" hide-header-close hide-footer title="Equipes du Gymnaste Pour la saison Actuelle">
                            <gymnaste-equipe :gymnaste_id="gym.id" :saison_id="saison_id"></gymnaste-equipe>
                            <b-button @click="hideModalTeam">Fermer</b-button>
                        </b-modal>
                    </b-card-text>


                </b-card>




                <!--Horaires-->
                <b-card tag="article"

                        class="mb-12 "
                >
                    <b-card-text>


                        <span v-for="(horaire,index) in gym.horaires"><horaires :horaires="horaire" :titre="index"></horaires></span>
                        <!--<horaires :horaire="horaires"></horaires>-->


                    </b-card-text>


                </b-card>
                <!--fin horaires-->






            </b-col>

            <!--Fin  Fiche synthese -->

            <!-- fiche niveau/groupe -->
            <b-col lg="3" xs="12">






                <b-card v-if="admin" tag="Saisons"

                        class="mb-12 "
                >
                    <b-card-text>







                        <h3>Saisons</h3>


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







                    </b-card-text>


                </b-card>




                <b-card v-if="admin" tag="validations"

                        class="mb-12 "
                >
                    <b-card-text>
                        <h2 >
                            Tarifs/Paiements
                        </h2>

                        <span  v-if="admin && gym.problemes.paiement">
                                <b-button  variant="success" v-on:click="validpaiement(gym.tarif)">Valider le tarif de {{gym.tarif}}€</b-button>
                                <b-button  variant="success" v-on:click="validpaiement(gym.tarif-10)">Valider le tarif de {{gym.tarif-10}}€ (Réduction Familiale à partir du 2eme inscrit)</b-button>
                            </span>
                        <b-button v-else-if="admin && !gym.problemes.Groupe" v-on:click="annulpaiement()" variant="info">Annuler le tarif enregistré : {{gym.paye}} €</b-button>
                        <br>
                        <span>Total Actuel à régler du responsable : {{gym.totalapayer}} €</span>



                    </b-card-text>


                </b-card>












            </b-col>
            <!-- fin fiche niveau/groupe-->


            <!-- fiche contact responsable -->
            <b-col v-if="admin" lg="3" xs="12">
                <b-card tag="article"

                        class="mb-12 text-right"
                >
                    <b-card-text>

                        <h3>Responsable</h3>
                        <modify-modal icon="fa fa-user mr-3" :admin="admin" field="nom" :id="gym.responsable.id" model="User" :value="gym.responsable.nom"></modify-modal>
                        <modify-modal icon="fa fa-user mr-3" :admin="admin" field="prenom" :id="gym.responsable.id" model="User" :value="gym.responsable.prenom"></modify-modal>
                        <modify-modal icon="fa fa-home mr-3" :admin="admin" field="adresse" :id="gym.responsable.id" model="User" :value="gym.responsable.adresse"></modify-modal>
                        <modify-modal icon="fa fa-home mr-3" :admin="admin" field="cp" :id="gym.responsable.id" model="User" :value="gym.responsable.cp"></modify-modal>

                        <modify-modal icon="fa fa-home mr-3" :admin="admin" field="ville" :id="gym.responsable.id" model="User" :value="gym.responsable.ville"></modify-modal>
                        <modify-modal icon="fa fa-envelope mr-3" :admin="admin" field="email" :id="gym.responsable.id" model="User" :value="gym.responsable.email"></modify-modal>
                        <modify-modal icon="fa fa-phone mr-3" :admin="admin" field="telephone1" :id="gym.responsable.id" model="User" :value="'0'+gym.responsable.telephone1"></modify-modal>
                        <modify-modal icon="fa fa-phone mr-3" :admin="admin" field="telephone2" :id="gym.responsable.id" model="User" :value="'0'+gym.responsable.telephone2"></modify-modal>
                        <modify-modal icon="fa fa-thumbs-up mr-3" :admin="admin" field="profession" :id="gym.responsable.id" model="User" :value="gym.responsable.profession"></modify-modal>






                    </b-card-text>


                </b-card>
            </b-col>
            <!-- fin contact responsable-->


        </b-row>
        
        <b-row>


        </b-row>






    </b-container>

    <b-modal id="photoupload" hide-footer>
        <form method="post" :action="'/gymnastes/'+gym.id+'/photo'" enctype="multipart/form-data">
            <input type="hidden" name="_token" :value="csrf">
            <input id="laphoto" name="laphoto" type="file"  data-filename-placement="inside">

            <input type="submit" class="btn btn-success" value="Envoyer">

        </form>
    </b-modal>



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

            update: function () {
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
