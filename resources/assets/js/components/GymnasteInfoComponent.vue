<template>
<div>




    <b-container fluid class="bv-example-row">
        <b-row>
            <!--Photo-->
            <b-col sm="12" lg="2">
                <b-card tag="article"

                        class="mb-12 text-center"
                >
                    <b-card-text>
                        <b-img thumbnail fluid :src="gym.photo_url" alt="ID" width="180"></b-img>
                        <b-button v-b-modal.photoupload variant="success">Envoyer</b-button>
                        <b-button v-if="admin" variant="success"
                                  :href="'/inscription/gymnastes/'+ gym.id+'/photo/take'">Webcam
                        </b-button>
                        <H3><span v-if="(admin)"><b-button :href="'/inscription/gymnastes/'+ gym.id+'/photo/crop'"
                                                           variant="info">Recadrer</b-button></span></H3>


                    </b-card-text>


                </b-card>
            </b-col>

        </b-row>
        test col 2
        <b-row>


        </b-row>






    </b-container>

    <b-modal id="photoupload" hide-footer>
        <form method="post" :action="'/gymnastes/'+gym.id+'/photo'" enctype="multipart/form-data">
            <input type="hidden" name="_token" :value="csrf">
            <input id="laphoto" name="laphoto" type="file"  data-filename-placement="inside">

            <input type="submit" class="btn btn-success" value="Envoyer">

        </form>
    </b-modal>



</div>

</template>

<script>

    export default {


        props: {
            admin:{
                type: Boolean,
                default: false
            },
            idgym: {
                type: Number

            },
            gym:{
                type: Object
            },
            csrf:{
                type: String
            },
            debug:
                {
                    type: Boolean,
                    default: false
                },
            write:{
                type: Boolean,
                default:false
            },
            contact:{
                type: Boolean,
                default: true
            },
            saison_id:{
                type: Number
            }



        },
        data() {
            return {

                update:"",

                filters: {
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                },






            }
        },
        methods: {

            update: function () {
                console.log('Mise à jour DB pour ' + this.idgym);
                axios
                    .get('/api/admin/gymnastes/' + this.idgym)
                    .then(response => (this.gym = response.data))
                ;


            },
            validcertif: function(){
                console.log('clic le certif ');
                axios
                    .get('/api/admin/gymnastes/' + this.gym.id+ '/certificatmedical/valid')

                ;
                //location.reload();
            },
            validpaiement: function(montant,saison_id){
                console.log('clic le paiement pour '+ montant + ' pour saison ' + this.saison_id);
                axios
                    .get('/api/inscription/gymnastes/' + this.gym.id +  '/saison/'+ this.saison_id + '/paiement/valid/' + montant)
                    .then(response => (this.update= response.data));


                //location.reload();
            },
            annulpaiement: function(montant,saison_id){
                console.log('clic le paiement pour '+ montant + ' pour saison ' + this.saison_id);
                axios
                    .get('/api/inscription/gymnastes/' + this.gym.id +  '/saison/'+ this.saison_id + '/paiement/valid/' + 0)
                    .then(response => (this.update= response.data));;


                //location.reload();
            },

            getcurrent: function() {
                axios
                    .get('/api/saisons/actuelle')
                    .then(response => (this.saison_id = response.data));

            },
            hideModalTeam() {
                this.$root.$emit('bv::hide::modal', 'equipes', '#btnShow');
                location.reload();
            },

        },

        mounted() {
            this.getcurrent();
            //this.update();



        },

        watch: {
            update: function (val) {
                if(val != "")
                {
                    console.log('update forcée');
                    location.reload();
                }
            }
        }





    }

</script>
