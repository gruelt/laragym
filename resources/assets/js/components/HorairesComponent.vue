<template>
    <b-card
            :title="'Horaires ' + titre "

            img-alt="Image"
            img-top
            tag="article"

            class="mb-12"
    >
        <b-card-text>

            <b-list-group>
                <b-list-group-item v-for="horaire in horaires">
                    <!--{{horaire.jour.nom_jour}} : {{horaire.heure_debut}}h{{horaire.minute_debut}} / {{horaire.heure_fin}}h{{horaire.minute_fin}}-->
                    <modify-horaire-modal :admin="admin" :horaire="horaire"></modify-horaire-modal>
                    <!--<modify-modal :admin="admin" field="nom" :id="equipe.id" model="Equipe" :value="equipe.nom"></modify-modal>-->

                </b-list-group-item>

                <b-button-group v-if="equipe_id!=0" size="xs">
                    <b-button variant="success" :href="'/admin/equipes/'+equipe_id+'/horaires/add'">+</b-button>


                </b-button-group>

            </b-list-group>
        </b-card-text>


    </b-card>
</template>

<script>
    export default {
        props:{
            admin:{
                type: Boolean,
                default: false
            },
            horaires:[],
            titre:{
                type: String,
                default: ""
            },
            equipe_id:{
                type: Number,
                default: "0"
            }
        },
        mounted() {

        },
        methods: {



        },

        mounted(){

        }
    }
</script>