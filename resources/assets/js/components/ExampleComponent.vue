<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ajouter</div>

                    <div class="card-body">
                        I'm an example component.

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        methods: {

            toggle(form){
                console.log(form);
            },

            update: function() {
                axios
                    .get('/api/responsables/gymnastes'+ this.idaccount)
                    .then(response => (this.fields = response.data));
                console.log('Chargement du type de compte '+this.idaccount);
            },



        },

        mounted(){
            this.update();
        }
    }
</script>
