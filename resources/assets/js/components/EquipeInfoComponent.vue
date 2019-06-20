<template>





    <div class="container-fluid d-flex h-100">







                        <!--Horaires groupe-->
                        <div class="card col-md-4 col-sm-12">


                            <div class="col-md-4 col-sm-12 text-left flex-fill">
                                <h3 class="card-title">
                                    Horaires
                                </h3>

                                <span>Lundi</span><br>
                                <span>Lundi</span><br>
                                <span>Lundi</span><br>






                            </div>






                        </div>

                        <!--Fin horaires groupe-->

                        <!--Coach-->
                        <div class="card col-md-4 col-sm-12">


                            <div class="col-md-4 col-sm-12 text-left flex-fill">
                                <h3 class="card-title">
                                    Coach
                                </h3>

                                <span>Lundi</span><br>
                                <span>Lundi</span><br>
                                <span>Lundi</span><br>






                            </div>






                        </div>

                        <!--Fin Coach-->


        <!--Liste Gyms-->

        <div class="card col-md-12">


            <div class="col-md-4 col-sm-12 text-left flex-fill">
                <h3 class="card-title">
                    Coach
                </h3>

                <span>Lundi</span><br>
                <span>Lundi</span><br>
                <span>Lundi</span><br>






            </div>






        </div>


                                    <


        </div>









</template>

<script>

    export default {


        props: {

            equipe_id: {
                type: Number

            },
            gym:{
                type: Object
            },


        },
        data() {
            return {

                update:"",
                equipe:"",







            }
        },
        methods: {

            updateteam: function () {
                 console.log('Mise à jour DB pour ' + this.equipe_id);
                 axios
                     .get('/api/admin/equipes/' + this.equipe_id)
                     .then(response => (this.equipe = response.data))
                 ;


            }

        },

        mounted() {

            this.updateteam();



        }





    }

</script>
