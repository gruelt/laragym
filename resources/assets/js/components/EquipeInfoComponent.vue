<template>


    <b-container fluid class="bv-example-row">
        <b-row>
            <!--Carte ID du groupe-->
            <b-col sm="12" lg="2">
                            <b-card


                                    img-src="/images/team.jpg"
                                    img-alt="Image"
                                    img-top
                                    tag="article"

                                    class="mb-12"
                            >
                                <b-card-text>

                                    <h2><modify-modal :admin="admin" field="nom" :id="equipe.id" model="Equipe" :value="equipe.nom"></modify-modal></h2>


                                    <h5 v-html="equipe.genre_libelle"></h5>
                                    <h5>{{equipe.categorie}}</h5>


                                    <H3>{{equipe.nbgyms.length}} Membres</H3>
                                    <b-progress :value="equipe.nbgyms_count" max="10" show-progress animated ></b-progress>
                                </b-card-text>


                            </b-card>
            </b-col>



            <!--Horaires-->
            <b-col lg="3" sm="12">

                <horaires :admin="admin" :horaires="equipe.horaires" :equipe_id="equipe_id"></horaires>
            </b-col>
            <!--Coach(s)-->

            <b-col lg="3" sm="6">
                <b-card
                        title="Entraineur(s)"

                        img-alt="Image"
                        img-top
                        tag="article"

                        class="mb-12"
                >
                    <b-card-text>
                        <span v-if="(admin)"><b-button v-b-modal.coachs variant="success" size="sm">Gérer</b-button></span><br>

                        <span v-html="equipe.coach"></span>





                        <b-modal id="coachs"  hide-footer title="Coachs">
                            <coach-equipe :equipe_id="equipe.id"></coach-equipe>
                            <b-button @click="hideModalcoach">Fermer</b-button>

                        </b-modal>




                    </b-card-text>


                </b-card>
            </b-col>

            <!--Fin coach-->
            <!--Compétitions-->

            <b-col lg="3" sm="6">
                <b-card
                        title="Compétitions"

                        img-alt="Image"
                        img-top
                        tag="article"

                        class="mb-12"
                >
                    <b-card-text>


                        <b-list-group>
                            <b-list-group-item>Cras justo odioz</b-list-group-item>
                            <b-list-group-item>Dapibus ac facilisis in</b-list-group-item>
                            <b-list-group-item>Morbi leo risus</b-list-group-item>
                            <b-list-group-item>Porta ac consectetur ac</b-list-group-item>
                            <b-list-group-item>Vestibulum at eros</b-list-group-item>
                        </b-list-group>
                    </b-card-text>


                </b-card>
            </b-col>

            <!--Compétitions-->



        </b-row>

                <b-col col="12">
                        <gymnaste-table :equipe_id="equipe_id"></gymnaste-table>
                </b-col>

        <b-row>

        </b-row>

    </b-container>















</template>

<script>

    export default {


        props: {

            equipe_id: {
                type: Number

            },
            gym:{
                type: Object
            },
            admin:{
                type:Boolean,
                default:false
            }


        },
        data() {
            return {

                update:"",
                equipe:"",







            }
        },
        methods: {

            updateteam: function () {
                 console.log('Mise à jour DB pour ' + this.equipe_id);
                 axios
                     .get('/api/admin/equipes/' + this.equipe_id)
                     .then(response => (this.equipe = response.data))
                 ;


            },
            hideModalcoach() {
                this.$root.$emit('bv::hide::modal', 'equipes', '#btnShow');
                location.reload();
            },

        },

        mounted() {

            this.updateteam();



        }





    }

</script>
