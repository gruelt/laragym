<template>
    <div>
        <a href="/admin/responsables/add/" type="button" class="btn btn-success btn-lg btn-block">+ Ajouter un responsable</a>
        <saison-select v-if="equipe_id == Null"></saison-select>
        <!--<button v-on:click="togglephotos" class="btn" v-bind:class="{'btn-primary': withphotos,'btn-secondary': !withphotos}">Photos</button>-->
        <!--<button v-on:click="togglehoraires" class="btn" v-bind:class="{'btn-primary': withhoraires,'btn-secondary': !withhoraires}">Horaires</button>-->
        {{filteredgyms.length}} Responsables
        <b-table
                id="table-transition-example"
                :items="filteredgyms"
                :fields="fields"
                striped
                small
                responsive

                primary-key="a"
                :tbody-transition-props="transProps"
        >
            <!--<span slot="nom" slot-scope="data" >-->
                <!--<a :href="'/admin/responsables/'+ data.item.id">{{data.value}}</a>-->
            <!--</span>-->

            <template slot="top-row" slot-scope="{ fields }">
                <td v-for="field in fields" :key="field.key">
                    <input v-model="filters[field.key]" :placeholder="field.label">
                </td>
            </template>

            <span slot="telephone1" slot-scope="data" >
                0{{data.value}}
            </span>
            <span slot="telephone2" slot-scope="data" >
                0{{data.value}}
            </span>




        </b-table>{{gyms}}
        <span v-if="debug">{{gyms}}</span>
    </div>
</template>

<script>

    export default {
        name: "ResponsablesTableComponent"

        ,
        props:{
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
        },
        methods: {

            toggle(form){
                console.log(form);
            },
            togglephotos(){
                this.withphotos = ! this.withphotos;
            },

            update: function() {

                    axios
                    .get('/api/admin/responsables/saison/'+this.saison_id)
                    .then(response => (this.gyms = response.data));


            },
            updateteam: function() {
                axios
                    .get('/api/admin/equipes/'+this.equipe_id+'/members')
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




        },




        data() {
            return {

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
                        key: 'adresse',
                        label: 'Adresse',
                        sortable: true
                    },
                    {
                        key: 'cp',
                        label: 'CP',
                        sortable: true
                    },
                    {
                        key: 'ville',
                        label: 'Ville',
                        sortable: true
                    },
                    {
                        key: 'email',
                        label: 'Email',
                        sortable: true
                    },
                    {
                        key: 'telephone1',
                        label: 'Telephone 1',
                        sortable: true
                    },
                    {
                        key: 'telephone2',
                        label: 'Telephone 2',
                        sortable: true
                    },
                    {
                        key: 'profession',
                        label: 'Profession',
                        sortable: true
                    },


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
            if(this.equipe_id == null)
            {
                this.getcurrentseason();
                //this.update();
            }
            else {
                this.withphotos=true;
                this.updateteam();
            }

        },

        computed: {
            filteredgyms () {
                const filtered = this.gyms.filter(item => {
                    return Object.keys(this.filters).every(key =>
                        String(item[key]).toLowerCase().includes(this.filters[key].toLowerCase()))
                })
                return filtered.length > 0 ? filtered : [{
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                }]
            }
        }


    }

</script>

<style scoped>

</style>