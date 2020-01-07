<template>
    <div class="container">


        <b-button v-b-modal.addgym variant="success">Ajouter Gymnaste</b-button>




        <b-modal id="addgym" hide-footer title="Gymnaste à ajouter">


            <b-table
                id="table-transition-example"
                :items="filteredgyms"
                :fields="fields"
                striped
                small




                primary-key="a"
                :tbody-transition-props="transProps"
            >

                <template slot="top-row" slot-scope="{ fields }">
                    <td v-for="field in fields" :key="field.key">
                        <input  type=text  :size="field.size" v-model="filters[field.key]" >


                    </td>
                </template>


                <span slot="niveaux" slot-scope="data" v-html="data.value"></span>

                <span slot="nom" slot-scope="data" >

               {{data.value}}
                </span>

                <span slot="add" slot-scope="data" >
                <b-button v-on:click="attach(data.item.id)" variant="success"><i class="fas fa-plus"></i></b-button>
            </span>


            </b-table>



        </b-modal>












    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props:{
            debug:{
                type: Boolean,
                default:false
            },
            equipe_id:{
                type: Number,
                default:0
            }
        },
        methods: {

            toggle(form){
                console.log(form);
            },

            update: function() {
                axios
                    .get('/api/admin/competitifs/'+this.equipe_id+'/gymnastes/eligibles') // /admin/gymnstates
                    .then(response => (this.gymnastes = response.data));
                console.log('Chargement du type de compte '+this.idaccount);
            },

            attach: function(idgym) {

                axios
                    .post('/api/admin/competitifs/'+this.equipe_id+'/gymnastes/'+idgym+'/add');
                this.update();


                console.log('Chargement du type de compte '+this.idaccount);
            },





        },

        data() {
            return {
                gymnastes: [],
                gymattach: 0,
                filters: {
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                },
                fields: [


                    {
                        key: 'nom',
                        label: 'Nom',
                        sortable: true,
                        size: '6'
                    },
                    {
                        key: 'prenom',
                        label: 'Prénom',
                        sortable: true,
                        size: '6'
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
                        size: '6'
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
                        key: 'add',
                        label: 'Ajouter',
                        sortable: true,
                        size: '2'
                        // Variant applies to the whole column, including the header and footer

                    }

                ],
            }
        },

        mounted(){
            this.update();
        },
        computed: {
            filteredgyms() {
                const filtered = this.gymnastes.filter(item => {
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
