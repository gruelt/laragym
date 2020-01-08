<template>
    <div>

        <saison-select v-if="equipe_id == Null && user_id ==Null && competitif_id == Null"></saison-select>
        <button v-on:click="togglephotos" class="btn" v-bind:class="{'btn-primary': withphotos,'btn-secondary': !withphotos}">Photos</button>
        <button v-on:click="togglehoraires" class="btn" v-bind:class="{'btn-primary': withhoraires,'btn-secondary': !withhoraires}">Horaires</button>



        <b-button @click="$bvModal.show('modal-mail');makemail()"  variant="success"><i class="fas fa-mail-bulk"></i>Mail à liste</b-button>

        {{filteredgyms.length}} Inscrits

        <b-modal id="modal-mail" title="mail">
            <p class="my-4">

                <b-form-textarea
                        id="textarea"
                        v-model="maillist"
                        placeholder="Enter something..."
                        rows="3"
                        max-rows="6"
                >



                </b-form-textarea>

            </p>
        </b-modal>

        <b-table
                id="table-transition-example"
                :items="filteredgyms"
                :fields="fields"
                striped
                small




                primary-key="a"
                :tbody-transition-props="transProps"
        >
            <span slot="nom" slot-scope="data" >
                <b-button v-if="competitif_id" v-on:click="detachcompetitif(data.item.id,competitif_id)" variant="danger"><i class="fas fa-minus"></i></b-button>
                <a :href="'/admin/gymnastes/'+ data.item.id">{{data.value}}</a>
            </span>

            <template slot="top-row" slot-scope="{ fields }">
                <td v-for="field in fields" :key="field.key">
                 <input  type=text  :size="field.size" v-model="filters[field.key]" >


                </td>
            </template>


            <span slot="photo_url" slot-scope="data" >
                <a :href="'/admin/gymnastes/'+ data.item.id">
                    <img v-if="withphotos" :src="data.value"  width="120" height="160" alt="">
                </a>
            </span>

            <span slot="problemes" slot-scope="data" >

                <b-button variant="danger" v-for="(prob, index) in data.value" :key="index">{{index}}</b-button>
                <h1 v-for="(prob, index2) in data.value" :key="index2">{{index2}}</h1>



            </span>


            <span slot="niveaux" slot-scope="data" v-html="data.value"></span>

            <span v-if="withhoraires" slot="horairescompact" slot-scope="data" v-html="data.value"></span>



            <span slot="url" slot-scope="data" >
                <a :href="'/admin/gymnastes/'+ data.item.id">Consulter</a>
            </span>


        </b-table>

        <!--<span v-if="debug">{{gyms}}</span>-->
        {{gyms}}
    </div>
</template>

<script>

    export default {
        name: "gymnastesTableComponent"

        ,
        props:{
            autoupdate:{
                type:Boolean,
                default:false
            },
            quick:{
                type:Boolean,
                default:false
            },
            debug:{
                type: Boolean,
                default:true
            },
            equipe_id:
                {
                    default: null,
                    type: Number,
                },
            competitif_id:
                {
                    default: null,
                    type: Number,
                },
            user_id:
                {
                    default: null,
                    type: Number,
                },
        },
        methods: {

            toggle(form){
                console.log(form);
            },
            togglephotos(){
                this.withphotos = ! this.withphotos;
            },

            update: function() {
                if(this.quick==false)
                {
                axios
                    .get('/api/admin/gymnastes/saison/'+this.saison_id)
                    .then(response => (this.gyms = response.data));

            }
            else
                {
                    axios
                    .get('/api/admin/gymnastes/saison/'+this.saison_id+"/quick")
                    .then(response => (this.gym = response.data));
                }

            },
            updateteam: function() {
                axios
                    .get('/api/admin/equipes/'+this.equipe_id+'/members')
                    .then(response => (this.gyms = response.data));

            }
            ,
            updatecompetitif: function() {
                axios
                    .get('/api/admin/competitifs/'+this.competitif_id+'/members')
                    .then(response => (this.gyms = response.data));

            }
            ,
            updateuser: function() {
                axios
                    .get('/api/admin/responsables/'+this.user_id+'/members')
                    .then(response => (this.gyms = response.data));

            },
            updatesaison(saison_id) {
                this.saison_id = saison_id;
                this.update();
            },
            getcurrentseason: function() {
                axios
                    .get('/api/saisons/actuelle')
                    .then(response => (this.saison_id = response.data));

            },
            togglehoraires(){
                this.withhoraires = ! this.withhoraires;
            },
            // Génere la liste des mails du listing
            makemail(){

                // for (var gym in this.gyms) {
                //     this.maillist+= gym.responsable;
                // }
                this.maillist="";
                this.filteredgyms.forEach((gym) => {
                    this.maillist+= gym.responsable.email+",";
                });
                }
                ,
            detachcompetitif: function(idgym,idequipe) {

                axios
                    .delete('/api/admin/competitifs/'+idequipe+'/gymnastes/'+idgym+'/detach');
                this.updatecompetitif();


                console.log('Chargement ');
            },






        },




        data() {
            return {
                maillist: "Wait",
                saison_id: "2",
                gyms: [],
                withphotos: false,
                filters: {
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                },
                withhoraires:false,
                fields: [

                    {
                        key: 'photo_url',
                        label: 'Photo',
                        sortable: true
                    },
                    {
                        key: 'nom',
                        label: 'Nom',
                        sortable: true
                    },
                    {
                        key: 'prenom',
                        label: 'Prénom',
                        sortable: true
                    },
                    {
                        key: 'age',
                        label: 'Age',
                        sortable: true,

                        size: '2'

                        // Variant applies to the whole column, including the header and footer
                        // thStyle: { backgroundColor: '#FFef44', maxWidth: '10px'},

                    },
                    {
                        key: 'niveaux',
                        label: 'Groupes',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    },
                    {
                        key: 'competitifs',
                        label: 'Compétitif',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    },
                    {
                        key: 'genre_libelle',
                        label: 'Genre',
                        sortable: true,
                        size: '2'
                        // Variant applies to the whole column, including the header and footer

                    }
                    ,
                    {
                        key: 'horairescompact',
                        label: 'Horaires',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    }
                    ,
                    {
                        key: 'problemes_short',
                        label: 'Problèmes',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    }
                    // ,
                    // {
                    //     key: 'url',
                    //     label: 'Consulter',
                    //
                    //     // Variant applies to the whole column, including the header and footer
                    //
                    // }
                ],

            }
        },

        mounted(){
            if(this.equipe_id == null && this.user_id == null && this.competitif_id == null)
            {
                this.getcurrentseason();
                //this.update();
            }
            else {

                this.withphotos=true;

                if(this.equipe_id !=null) {
                    this.updateteam();
                }

                if(this.competitif_id !=null) {
                    this.updatecompetitif();

                    this.interval = setInterval(function () {
                        if(this.autoupdate==true ) {

                            this.updatecompetitif();

                        }
                    }.bind(this),  2000);

                }

                if(this.user_id !=null) {
                    this.updateuser();
                }

            }

        },

        computed: {
            filteredgyms() {
                const filtered = this.gyms.filter(item => {
                    return Object.keys(this.filters).every(key =>
                        String(item[key]).toLowerCase().includes(this.filters[key].toLowerCase()))
                })
                return filtered.length > 0 ? filtered : [{
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                }]
            },







        }


    }

</script>

<style scoped>

</style>
