<template>


    <b-container fluid class="bv-example-row">
        <b-row>
            <!--Carte ID du groupe-->
            <b-col sm="12" lg="2">
                            <b-card


                                    img-src="/images/compet.png"
                                    img-alt="Image"
                                    img-top
                                    tag="article"

                                    class="mb-12"
                            >
                                <b-card-text>

                                    <h2><modify-modal :admin="admin" field="nom" :id="equipe.id" model="Competitif" :value="equipe.nom"></modify-modal></h2>


                                    <h5 v-html="equipe.genre_libelle"></h5>
                                    <h5>{{equipe.categorie}}</h5>


                                    <H3>{{equipe.nbgyms.length}} Membres

                                    </H3>
                                    <H5>{{equipe.niveau.nb_gyms}} gyms / {{equipe.niveau.nb_notes}} notes</H5>


                                    <b-progress :value="equipe.nbgyms_count" :max="equipe.niveau.nb_gyms" show-progress animated ></b-progress>

                                </b-card-text>


                            </b-card>
            </b-col>



            <!--Horaires + tarifs-->
            <b-col lg="3" sm="12">

                                <b-card
                                        title="Ajouter Gymnaste"

                                        img-alt="Image"
                                        img-top
                                        tag="article"

                                        class="mb-12"
                                >
                                    <b-card-text>


                                        <gymnaste-attach to="competitif" :equipe_id="equipe_id"></gymnaste-attach>


                                    </b-card-text>


                                </b-card>



            </b-col>
            <!--Coach(s)-->

            <b-col lg="3" sm="6">

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
                        <gymnaste-table :competitif_id="equipe_id" :autoupdate="true"></gymnaste-table>
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
            },
            autoupdate:{
                type:Boolean,
                default:true
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
                     .get('/api/admin/competitifs/' + this.equipe_id)
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
