<template>
    <div>
       <gymnaste-card :gyms="gyms"></gymnaste-card>
        <a href="/responsable/gymnastes/add/" type="button" class="btn btn-success btn-lg btn-block">+ Ajouter un gymnaste</a>       {{gyms}}
    </div>
</template>

<script>
    export default {
        name: "gymnastesListComponent"

    ,
    methods: {

        toggle(form){
            console.log(form);
        },

        update: function() {
            axios
                .get('/api/responsables/gymnastes')
                .then(response => (this.gyms = response.data));

        },




    },

        data() {
            return {

                gyms: 'rien',


            }
        },

    mounted(){
        this.update();
    }

    }
</script>

<style scoped>

</style>