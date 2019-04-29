<template>
    <div>
       <!--<gymnaste-card></gymnaste-card>-->
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