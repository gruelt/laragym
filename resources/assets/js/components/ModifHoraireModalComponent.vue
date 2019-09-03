<template>
    <div>
        <div v-if="admin">


            {{horaire.jour.nom_jour}} : {{horaire.heure_debut}}h{{horaire.minute_debut}} / {{horaire.heure_fin}}h{{horaire.minute_fin}} &nbsp;


            <i v-if="lock" @click="togglelock" class="fas fa-lock fa-xs" ></i>

            <i v-if="!lock" @click="togglelock" class="fas fa-unlock fa-xs" ></i>&nbsp;&nbsp;&nbsp;
            <i v-if="!lock" style="color:blue" class="fas fa-pen fa-xs" @click="$bvModal.show('modal-horaire-'+horaire.id)"></i>&nbsp;&nbsp;<span :class="icon"></span>&nbsp;
            <i v-if="!lock" style="color:red" class="fas fa-trash fa-xs" @click="$bvModal.show('modal-horairedel-'+horaire.id)"></i>&nbsp;&nbsp;<span :class="icon"></span>

            <b-modal :id="'modal-horairedel-'+ horaire.id" title="Supprimer" hide-footer>
                <b-button :href="'/admin/horaires/'+ horaire.id + '/delete'" variant="danger">Supprimer cet horaire {{horaire.id}}</b-button>
                <b-button  variant="info" @click="$bvModal.hide('modal-horairedel-'+horaire.id)">Annuler</b-button>
            </b-modal>

            <b-modal :id="'modal-horaire-'+ horaire.id" title="Modifier" hide-footer>


                <!-- Jour-->
                <b-form-select v-model="horaire.jour_id" :options="jours" class="mb-3">
                </b-form-select>

                <!-- Début -->
                    <!-- Heure-->

                    <label  for="heure_debut">Début</label>
                    <b-form-input class="mb-2 mr-sm-2 mb-sm-0" v-model="horaire.heure_debut" id="heure_debut">  </b-form-input>

                    <b-form-input class="mb-2 mr-sm-2 mb-sm-0" v-model="horaire.minute_debut" id="minute_debut">  </b-form-input>

                    <!--Fin-->

                <label  for="heure_fin">Fin</label>
                    <b-form-input v-model="horaire.heure_fin" id="heure_fin">  </b-form-input>
                    <b-form-input  v-model="horaire.minute_fin" id="minute_fin">  </b-form-input>

                <b-button @click="pushupdate();$bvModal.hide('modal-horaire-'+horaire.id);"  variant="success">Ok</b-button>
                <!--<b-button @click="pushupdate();"  variant="success">Push</b-button>-->
            </b-modal>












        </div>
    <div v-else>
        {{horaire.jour.nom_jour}} : {{horaire.heure_debut}}h{{horaire.minute_debut}} / {{horaire.heure_fin}}h{{horaire.minute_fin}} &nbsp;

    </div>
    </div>
</template>

<script>
    export default {
        props:{
            id:{
                type: Number,
                required: true
            },

            admin:{
                type:Boolean,
                default:false
            },
            icon:{
                type:String,
                default: ""
            },
            horaire:{
                type:Array,
            }

        },

        data() {
            return {

                jours:[
                    { value: 1, text: 'Lundi' },
                    { value: 2, text: 'Mardi' },
                    { value: 3, text: 'Mercredi' },
                    { value: 4, text: 'Jeudi' },
                    { value: 5, text: 'Vendredi' },
                    { value: 6, text: 'Samedi' },
                    { value: 7, text: 'Dimanche' },


                ],

                jour:{
                    Type: Number
                },
                lock:{
                    Type: Boolean,
                    default:true
                }








            }
        },



        methods: {

            toggle(form){
                console.log(form);
            },
            togglelock(){
                this.lock = ! this.lock;
            },

            pushupdate: function() {
                axios
                    .post('/api/admin/equipes/'+ this.horaire.equipe_id + "/horaires/",
                        { horaire: this.horaire })
                    .then(response => (this.fields = response.data));
                console.log('Update '+this.horaire.equipe_id + this.horaire  );


                    location.reload();



            },



        },

        mounted(){

            if(this.display=="")
            {

                this.display=this.value;
                console.log(display+value);
            }
        }
    }
</script>