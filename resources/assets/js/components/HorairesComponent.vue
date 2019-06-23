<template>
    <b-card
            title="Horaires"

            img-alt="Image"
            img-top
            tag="article"

            class="mb-12"
    >
        <b-card-text>


            <b-list-group>
                <b-list-group-item v-for="horaire in horaires">{{horaire.jour.nom_jour}} : {{horaire.heure_debut}}h{{horaire.minute_debut}} / {{horaire.heure_fin}}h{{horaire.minute_fin}}</b-list-group-item>

            </b-list-group>
        </b-card-text>


    </b-card>
</template>

<script>
    export default {
        props:{
            horaires:[]
        },
        mounted() {

        },
        methods: {



        },

        mounted(){

        }
    }
</script>