<template>
    <div class="container">
        Saison <b-form-select v-model="selected" :options="options"></b-form-select>
    </div>
</template>

<script>
    export default {

        mounted() {
            console.log('Component mounted.')
        },
        props:{
          saison_id:""
        },
        methods: {
            update: function() {
                axios
                    .get('/api/saisons')
                    .then(response => (this.options = response.data));

            },
            getcurrent: function() {
                axios
                    .get('/api/saisons/actuelle')
                    .then(response => (this.selected = response.data));

            },
            getopened: function() {
                axios
                    .get('/api/saisons/ouverte')
                    .then(response => (this.selected = response.data));

            },



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
            this.getcurrent();
            this.update();
        }
        ,

        watch: {
            selected: function (val) {
                this.$parent.updatesaison(val);
                console.log('changement'+val);
            }
        }
    }
</script>