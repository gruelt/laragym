<template>
    <div>
        <b-table
                id="table-transition-example"
                :items="gyms"
                :fields="fields"
                striped
                small
                primary-key="a"
                :tbody-transition-props="transProps"
        ></b-table>
    </div>
</template>

<script>

    export default {
        name: "gymnastesTableComponent"

        ,
        props:{
            debug:{
                type: Boolean,
                default:true
            }
        },
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

                gyms: [],


            }
        },

        mounted(){
            this.update();
        }

    }

</script>

<style scoped>

</style>