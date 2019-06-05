<template>
    <div class="container">


        <b-form-checkbox-group
                id="checkbox-group-1"
                v-model="selected"
                :options="options"
                name="flavour-1"
                stacked
        ></b-form-checkbox-group>

    </div>
</template>

<script>
    export default {

        mounted() {
            console.log('Component mounted.')
        },
        props:{
          gymnaste_id:"",
            saison_id:""
        },
        methods: {
            getselected: function() {
                axios
                    .get('/api/admin/gymnastes/'+this.gymnaste_id+'/saison/'+ this.saison_id +'/equipes')
                    .then(response => (this.selected = response.data));

            },
            getlist: function() {
                axios
                    .get('/api/admin/equipes/saison/'+this.saison_id+"/1")
                    .then(response => (this.options = response.data));

            },
            save: function(){
                axios
                    .post('/api/admin/gymnastes/'+this.gymnaste_id+'/saison/'+ this.saison_id +'/equipes',{ equipes: this.selected });



            }
            ,
            reload: function(){
                location.reload();
            }



        },

        data() {
            return {
                selected: null,
                options: [
                    { value: null, text: 'Chargement en cours' },

                ]
            }
        },

        mounted(){

        },
        watch: {
            saison_id: function (val) {
                this.getselected();
                this.getlist();

            },
            selected: function(val){
                this.save();
            }

        }


    }
</script>