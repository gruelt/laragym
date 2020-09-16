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

                        <b-alert v-if="gym.certificat_medical == null && gym.certificat_medical_date == null" show variant="warning">Aucun Certificat Medical</b-alert>
                        <b-alert v-else show variant="info">
                            <a v-if="gym.certificat_medical != null && gym.certificat_medical_date !=null" :href="gym.certificat_medical_url"><i class="fas fa-file-alt"></i>&nbsp;Certificat Medical du {{gym.certificat_medical_date_fr}} valable jusqu'au {{gym.certificat_medical_fin_fr}} </a>
                            <span v-if="gym.certificat_medical == null && gym.certificat_medical_date !=null">Certificat saison précédente du {{gym.certificat_medical_date_fr}} valable jusqu'au {{gym.certificat_medical_fin_fr}}</span>


                            <b-badge v-if="(gym.certificat_medical_check == 0 && admin)" v-on:click="validcertif" variant="success">Valider le certificat</b-badge>
                            <b-badge v-if="gym.certificat_medical_check == 0" variant="warning">Attente Validation</b-badge>
                            <b-badge v-else variant="success">Vérifié</b-badge>


                        </b-alert>


                        <b-alert v-if="gym.certificat_medical_age >= 3" show variant="warning">Certificat dépassé</b-alert>


                        <h5 v-if="gym.certificat_medical_date != null || admin"><modify-modal :display="gym.certificat_medical_date_fr" :admin="admin" type="date" field="certificat_medical_date" :id="gym.id" model="Gymnaste" :value="gym.certificat_medical_date"></modify-modal></h5>

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

                <!--Facture-->
                <b-card tag="Facture"
                        title="Facture"
                        class="mb-12 text-center">

<!--                    -->
                    <b-btn v-if=" (  gym.paye !=0 ) && admin" :href="'/admin/gymnastes/'+ gym.id + '/facture/1'" variant="info"><i class="far fa-file-pdf"></i> Consulter la facture</b-btn>
                    <p v-else>
                        <b-btn v-if=" (  gym.paye !=0 ) && !admin " :href="'/responsable/gymnastes/'+ gym.id + '/facture'" variant="info"><i class="far fa-file-pdf"></i> Consulter la facture</b-btn>

                    </p>

                    <p v-if="gym.paye == 0">Paiement non validé.</p>
                </b-card>

                <!-- Fin Facture -->


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

                        <!--<H3>-->
                            <!--<span v-for="(niveau, id) in gym.niveaux_tab">-->
                                <!--<a :href="'/equipes/' + id " class="badge badge-primary >{{niveau['nom']}} <b-badge v-if="niveau['attente'] ==1" variant="danger">Liste Attente </b-badge></a>&nbsp;-->
                                        <!--<b-badge v-if="withattente" variant="danger">Changer </b-badge>-->
                            <!--</span><br></H3>-->

                        <H3>
                            <span v-for="(niveau, id) in gym.niveaux_tab">
                                <b-button variant="primary" block >{{niveau['nom']}} <b-badge v-if="niveau['attente'] ==1" variant="danger">Liste Attente </b-badge>
                                    <b-badge v-if="niveau['attente'] ==0" variant="info">Ok </b-badge>
                                        <b-badge v-if="withattente && niveau['attente'] ==1" @click="validteam(id,0)" variant="success">Intégrer au groupe </b-badge>
                                        <b-badge v-if="withattente && niveau['attente'] ==0" @click="validteam(id,1)" variant="danger">Mettre en attente </b-badge>
                                    <b-badge v-if="admin" :href="'/equipes/' + id ">Voir</b-badge>
                                </b-button>

                            </span>
                            <br>
                        </H3>







                        <H3><span v-if="(admin)">
                            <b-button v-b-modal.equipesnew variant="success">Gérer Equipes</b-button>
                            <b-button v-b-modal.equipes variant="success">Gérer Equipes Old</b-button></span>
                            <br><button v-if="(admin)" v-on:click="toggleattente" class="btn" v-bind:class="{'btn-primary': withattente,'btn-secondary': !withattente}">Bascule Attente/Confirmé </button></H3>
                        <b-modal id="equipes" hide-header-close hide-footer title="Equipes du Gymnaste Pour la saison Actuelle">
                            <gymnaste-equipe :gymnaste_id="gym.id" :saison_id="saison_id"></gymnaste-equipe>
                            <b-button @click="hideModalTeam">Fermer</b-button>
                        </b-modal>

                        <b-modal size="xl" id="equipesnew"  hide-footer title="New Equipes du Gymnaste Pour la saison Actuelle">
                            <gymnaste-equipe-new  :gymnaste_id="gym.id" :saison_id="saison_id"></gymnaste-equipe-new>
                            <b-button @click="hideModalTeam">Fermer</b-button>
                        </b-modal>






                        <h5 >
                            Equipes en compétition
                        </h5>

                        <!--<H3>-->
                        <!--<span v-for="(niveau, id) in gym.niveaux_tab">-->
                        <!--<a :href="'/equipes/' + id " class="badge badge-primary >{{niveau['nom']}} <b-badge v-if="niveau['attente'] ==1" variant="danger">Liste Attente </b-badge></a>&nbsp;-->
                        <!--<b-badge v-if="withattente" variant="danger">Changer </b-badge>-->
                        <!--</span><br></H3>-->

                        <H3>
                            <p v-html="gym.competitifs"></p>
                        </H3>





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

                                       <p v-if="saison.id==saison_id">
                                                <b-button v-if="saison.pivot.complet ==1"  variant="success">
                                                    {{saison.nom}} <b-badge variant="light">Complet</b-badge>
                                                </b-button>
                                                <b-button v-else  variant="info">
                                                    {{saison.nom}} <b-badge variant="light">Préinscrit</b-badge>
                                                    <span v-for="(probleme, index) in gym.problemes" variant="light" v-bind:key="probleme">

                                                    <b-badge  v-for="(subprobleme, index2) in probleme" :variant="subprobleme.class" :key="subprobleme">{{subprobleme.text}}</b-badge>
                                                </span>
                                                </b-button>
                                       </p>

                                        <p v-else>
                                            <b-button   variant="info">
                                                {{saison.nom}} <b-badge variant="light">Archive {{saison_id}} {{saison.id}}</b-badge>
                                            </b-button>
                                        </p>
                                </li>


                            </div>
                            <b-button v-if="gym.reinscrit.statut ==0 && gym.reinscrit.saison !=0 "  :href="'/responsable/gymnaste/' + gym.id +'/reinscrire/'+ gym.reinscrit.saison.id" variant="warning">
                                + Re-inscrire pour {{gym.reinscrit.saison.nom}}
                            </b-button>
                        </div>







                    </b-card-text>


                </b-card>




                <b-card  tag="validations"

                        class="mb-12 "
                >
                    <b-card-text>
                        <h2 >
                            Tarifs
                        </h2>

                        <span  v-if="admin && gym.problemes.paiement">
                                <b-button  variant="success" v-on:click="validpaiement(gym.tarif)">Valider le tarif de {{gym.tarif}}€</b-button>
<!--                                <b-button  variant="success" v-on:click="validpaiement(gym.tarif-10)">Valider le tarif de {{gym.tarif-10}}€ (Réduction Familiale à partir du 2eme inscrit)</b-button>-->
                            </span>
                        <b-button v-else-if="admin && !gym.problemes.Groupe" v-on:click="annulpaiement()" variant="info">Annuler le tarif enregistré : {{gym.paye}} €</b-button>
                        <br>
                        <span>Total Actuel à régler pour tous les gyms: {{gym.totalapayer}} €</span>

                        <hr>

                        <b-button v-if="!gym.problemes.Groupe" v-b-modal="'paiementinfo'" variant="success"><i class="fas fa-shopping-cart"></i> Payer en ligne avec Helloasso</b-button>

                        <b-modal id="paiementinfo" size="xl" hide-footer>

                                    <h2>Pour le paiement en ligne</h2>
                                        <ul>
                                            <li>Au moment de renseigner l'adresse mail , utiliser <b>{{gym.responsable.email}}</b>.</li>
                                            <li>La plateforme de paiement vous proposera de faire une donation , <b>ceci n'est pas obligatoire</b>.</li>
                                            <li>Vous pouvez faire des paiements plusieurs fois si des inscrits se rajoutent.</li>
<!--                                            <li>Les tarifs "en 3 fois" seront débités mensuellement.</li>-->
                                            <li>Vous pouvez faire un paiement unique pour tous vos inscrits.</li>
                                            <li>Choisir le tarif et le nombre d'inscrits dans chaque tarif.</li>
                                            <li>Les paiements seront vérifiés : si un mauvais tarif est choisi vous devrez compléter.</li>
                                            <li>Un paiement incomplet ne valide pas l'accés aux cours.</li>
<!--                                            <li>Les Tarifs en 3X coûtent en général 2€ de plus ( arrondi technique obligatoire) .</li>-->

                                            <li>Une fois validé , le paiement apparaitra sur cette page ( délai de 2 minutes possible ).</li>


                                        </ul>
                            <b-form-checkbox v-if="acceptpaiement==false"
                                id="checkbox-1"
                                v-model="acceptpaiement"
                                name="checkbox-1"
                                value=true
                                unchecked-value=false
                            >
                                J'ai lu et compris les consignes.
                            </b-form-checkbox>
                            <br>
                            <p v-for="saison in gym.saisons">
                                <b-button variant="success"  v-if="acceptpaiement && saison.actuelle==1"  :href="saison.helloassoslug"><i class="fas fa-shopping-cart"></i> Payer en ligne</b-button>
                            </p>

                            </b-modal>


                        <h2 >
                            Paiements
                        </h2>

                        <b-button v-if="admin" v-b-modal="'modal-paiement'" block variant="success">Ajouter Paiement</b-button>



                        <b-modal id="modal-paiement" size="xl" hide-footer>






                            <b-card bg-variant="light">
                                <b-form-group
                                    label-cols-lg="3"
                                    label="Ajouter Paiement ( 1 par chèque ) "
                                    label-size="lg"
                                    label-class="font-weight-bold pt-0"
                                    class="mb-0"

                                >
                                        <b-form-group
                                        label-cols-sm="3"
                                        label="Mode"
                                        label-align-sm="right" class="mb-0"

                                         >
                                        <b-form-radio-group
                                            class="pt-2"
                                            :options="['cheque', 'ancv', 'liquide']"
                                            v-model="paiement.type"
                                        ></b-form-radio-group>
                                    </b-form-group>

                                    <b-form-group
                                        label-cols-sm="3"
                                        label="Montant €"
                                        label-align-sm="right"
                                        label-for="montant"
                                    >
                                        <b-form-input id="montant" v-model="paiement.montant"></b-form-input>
                                    </b-form-group>

                                    <b-form-group
                                        label-cols-sm="3"
                                        label="Commentaire:"
                                        label-align-sm="right"
                                        label-for="commentaire"
                                    >
                                        <b-form-input v-model="paiement.commentaire" id="commentaire"></b-form-input>
                                    </b-form-group>

                                    <b-button @click="ajoutmoyenpaiement()">Ajouter</b-button>




                                </b-form-group>
                            </b-card>







                        </b-modal>



                        <b-card v-for="paiementmanuel in paiements" :title="paiementmanuel.type + ' '+ paiementmanuel.montant +'€'" :sub-title="frontEndDateFormat(paiementmanuel.created_at) + ' ' + paiementmanuel.operateur.nom+ ' ' + paiementmanuel.operateur.prenom">
                        <b-row>
                            <b-col lg="10" class="pb-2">

                                                        <b-card-text v-if="paiementmanuel.commentaire"><i class="fa fa-info-circle" aria-hidden="true"></i>
                                                            {{paiementmanuel.commentaire}}</b-card-text>
                            </b-col>
                            <b-col lg="2" class="pb-2">
                                <b-button v-if="admin" size="xs" variant="danger" v-b-modal="'deletepaiement-'+paiementmanuel.id"><i class="fa fa-trash" aria-hidden="true"></i></b-button>

                                <b-modal :id="'deletepaiement-'+paiementmanuel.id" hide-footer>


                                    <b-card :title="paiementmanuel.type + ' '+ paiementmanuel.montant +'€'" :sub-title="frontEndDateFormat(paiementmanuel.created_at) + ' ' + paiementmanuel.operateur.nom+ ' ' + paiementmanuel.operateur.prenom">
                                    </b-card>

                                    <b-button  variant="danger" @click="deletepaiement(paiementmanuel.id)"><i class="fa fa-trash" aria-hidden="true"></i>Confirmer la suppression</b-button>

                                </b-modal>


                            </b-col>
                        </b-row>
                            <!--                            <b-link href="#" class="card-link">Another link</b-link>-->
                        </b-card>













                        <b-card v-for="paiement in helloasso.data" :title="'HelloAsso '+ paiement.amount.total/100 +'€'" :sub-title="frontEndDateFormat(paiement.date)">
                            <b-card-text v-for="adherent in paiement.items">

                                <b-button variant="primary">
                                    {{adherent.name}} <b-badge variant="light">{{adherent.amount/100}}</b-badge>
                                </b-button>






                                 {{adherent.user.firstName}} - {{adherent.user.lastName}}
                            </b-card-text>

<!--                            <b-card-text>A second paragraph of text in the card.</b-card-text>-->

                            <a v-if="admin" href="https://www.helloasso.com/associations/fjep-gymnastique-saint-just-saint-rambert/administration/statistiques" class="card-link">Helloasso</a>
<!--                            <b-link href="#" class="card-link">Another link</b-link>-->
                        </b-card>








                    </b-card-text>


                </b-card>

                <b-card v-if="admin" tag="Dossier"

                        class="mb-12 "
                >
                    <b-card-text>
                        <h2 >
                            Dossier Papier
                        </h2>



                        <span  v-if="admin && gym.problemes.dossier">
                                <b-button  variant="success" v-on:click="validdossier(gym.id,1)">Valider dossier Ufolep</b-button>
                                <b-button  variant="success" v-on:click="validdossier(gym.id,2)">Valider le Dossier Baby </b-button>
                            </span>
                        <b-button v-else v-on:click="validdossier(gym.id,0)" variant="info">Marquer le dossier comme incomplet</b-button>

                        <b-badge v-if="gym.dossier==2">Dossier Baby Gym</b-badge>

                        <br>
                        <span></span>



                    </b-card-text>


                </b-card>



                <b-card v-if="admin && !gym.problemes.dossier" tag="Affiligue"

                        class="mb-12 "
                >
                    <b-card-text>
                        <h2 >
                            Affiligue
                        </h2>

                        <span  v-if="admin && gym.problemes.affiligue">
                                <b-button  variant="success" v-on:click="validaffiligue(gym.id,1)">Valider dossier Affiligue</b-button>

                            </span>
                        <b-button v-else-if="admin && !gym.problemes.Groupe && gym.dossier!=2" v-on:click="validaffiligue(gym.id,0)" variant="info">Marquer comme non saisi</b-button>

                        <b-badge v-if="gym.dossier==2">Dossier Baby Gym</b-badge>

                        <br>
                        <span></span>

<!--                        {{helloasso}}-->

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

                        <h3>Responsable <b-badge v-if="admin" :href="'/admin/responsables/' + gym.responsable.id ">Voir</b-badge></h3>
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
            adhurl:{
                type:String,
            },
            operateur:{
               type:Number
            },
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
                acceptpaiement:false,
                update:"",

                filters: {
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                },
                withattente:false,
                helloasso:"rien",


                paiement:{
                    type:"cheque",
                    montant:"0",
                    commentaire:"",
                },

                paiements:"",






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
            updatehelloasso: function()
                {
                    axios
                        .get('/api/admin/helloasso/adhesion/current/' + this.gym.responsable.email)
                        .then(response => (this.helloasso = response.data))
                    ;
                },
            updatepaiements: function()
            {
                axios
                    .get('/api/admin/responsable/'+this.gym.responsable.id+'/paiement/saison/actuelle')
                    .then(response => (this.paiements = response.data))
                ;
            },
            deletepaiement: function(id_paiement)
            {
                axios
                    .delete('/api/admin/responsable/'+this.gym.responsable.id+'/paiement/'+id_paiement)
                    .then(response => (this.paiements = response.data))
                ;

                this.update=1;
            },
            validteam: function (equipe_id,attente) {
                console.log('Mise à jour DB team ' + equipe_id + ' à ' + attente);
                axios
                    .get('/api/admin/gymnastes/'+ this.gym.id +'/equipes/' + equipe_id +"/attente/"+attente )
                    .then(response => (this.update= response.data));


                ;


            },
            validcertif: function(){
                console.log('clic le certif ');
                axios
                    .get('/api/admin/gymnastes/' + this.gym.id+ '/certificatmedical/valid')

                ;
                //location.reload();
            },
            validdossier: function(gym_id,statut){
                console.log('clic le dossier '+ statut);
                axios
                    .get('/api/admin/gymnastes/' + this.gym.id+ '/dossier/'+ statut)
                    .then(response => (this.update= response.data));
                //location.reload();
            },
            validaffiligue: function(gym_id,statut){
                console.log('clic le dossier '+ statut);
                axios
                    .get('/api/admin/gymnastes/' + this.gym.id+ '/affiligue/'+ statut)
                    .then(response => (this.update= response.data));
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
            toggleattente(){
                this.withattente = ! this.withattente;
            },
            frontEndDateFormat: function(date) {
                return moment(date).format('DD/MM/YYYY HH:mm');
            },

            ajoutmoyenpaiement: function()
            {

                console.log('responsable '+ this.gym.responsable.id +'clic ajout de '+ this.paiement.type +' pour '+ this.paiement.montant + ' avec commentaire ' + this.paiement.commentaire);

                axios.post('/api/admin/responsable/'+ this.gym.responsable.id + '/paiement/add',

                    {
                        type: this.paiement.type,
                        montant: this.paiement.montant,
                        commentaire: this.paiement.commentaire,
                        responsable_id: this.gym.responsable.id,
                        saison_id: this.saison_id,
                        operateur_id: this.operateur

                    }
                );

                this.update=1;


                return 1;
            }


        },

        mounted() {
            this.getcurrent();
            //this.update();
            this.updatehelloasso();
            this.updatepaiements();


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
