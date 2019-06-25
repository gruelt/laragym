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
          equipe_id:"",

        },
        methods: {
            getselected: function() {
                axios
                    .get('/api/admin/equipes/'+this.equipe_id+'/coachs/ids')
                    .then(response => (this.selected = response.data));

            },
            getlist: function() {
                axios
                    .get('/api/admin/coachs/pluck')
                    .then(response => (this.options = response.data));

            },
            save: function(){
                axios
                    .post('/api/admin/equipes/'+this.equipe_id+'/coachs/',{ coachs: this.selected });



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
            this.getselected();
            this.getlist();
        },
        watch: {
            equipe_id: function (val) {
                this.getselected();
                this.getlist();

            },
            selected: function(val){
                this.save();
            }

        }


    }
</script>