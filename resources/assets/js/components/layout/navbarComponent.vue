<template>
    <v-toolbar
            color="red"
            dense
            fixed
            clipped-left
            app
    >
        <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
        <v-icon class="mx-3">fa-youtube</v-icon>
        <v-toolbar-title class="mr-5 align-center">
            <span class="title">{{title}}</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-layout row align-center style="max-width: 650px">
            <v-button v-if="logged" >Se déconnecter</v-button>

            <v-button v-if="logged === false" >Se Connecter</v-button>
        </v-layout>
    </v-toolbar>
</template>

<script>
    export default {
        name: "navbarComponent",
        props: {
            logged:
                {
                    type: Boolean,
                    default: false
                },
            title:{
                type: String,
                default: "Titre"
            }
        }
    }
</script>

<style scoped>

</style>