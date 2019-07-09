<template>


    <b-container fluid class="bv-example-row">
        <b-row>
            <!--Carte ID du groupe-->
            <b-col sm="12" lg="2">

                <b-card tag="article"

                        class="mb-12 text-right"
                >

                <b-card-text>

                    <h3>Responsable</h3>
                    <modify-modal icon="fa fa-user mr-3" :admin="admin" field="nom" :id="user.id" model="User" :value="user.nom"></modify-modal>
                    <modify-modal icon="fa fa-user mr-3" :admin="admin" field="prenom" :id="user.id" model="User" :value="user.prenom"></modify-modal>
                    <modify-modal icon="fa fa-home mr-3" :admin="admin" field="adresse" :id="user.id" model="User" :value="user.adresse"></modify-modal>
                    <modify-modal icon="fa fa-home mr-3" :admin="admin" field="cp" :id="user.id" model="User" :value="user.cp"></modify-modal>

                    <modify-modal icon="fa fa-home mr-3" :admin="admin" field="ville" :id="user.id" model="User" :value="user.ville"></modify-modal>
                    <modify-modal icon="fa fa-envelope mr-3" :admin="admin" field="email" :id="user.id" model="User" :value="user.email"></modify-modal>
                    <modify-modal icon="fa fa-phone mr-3" :admin="admin" field="telephone1" :id="user.id" model="User" :value="'0'+user.telephone1"></modify-modal>
                    <modify-modal icon="fa fa-phone mr-3" :admin="admin" field="telephone2" :id="user.id" model="User" :value="'0'+user.telephone2"></modify-modal>
                    <modify-modal icon="fa fa-thumbs-up mr-3" :admin="admin" field="profession" :id="user.id" model="User" :value="user.profession"></modify-modal>






                </b-card-text>

                </b-card>




            </b-col>







        </b-row>

                <b-col col="12">
                        <gymnaste-table :user_id="user_id"></gymnaste-table>
                </b-col>

        <b-row>

        </b-row>

    </b-container>















</template>

<script>

    export default {


        props: {

            user_id: {
                type: Number

            },
            user:{
                type: Object
            },
            admin:{
                type:Boolean,
                default:false
            }


        },
        data() {
            return {

                update:"",
                equipe:"",







            }
        },
        methods: {

            updateuser: function () {
                 console.log('Mise à jour DB pour ' + this.user_id);
                 axios
                     .get('/api/admin/responsables/' + this.user_id)
                     .then(response => (this.user = response.data))
                 ;


            },
            hideModalcoach() {
                this.$root.$emit('bv::hide::modal', 'equipes', '#btnShow');
                location.reload();
            },

        },

        mounted() {

            this.updateuser();



        }





    }

</script>
