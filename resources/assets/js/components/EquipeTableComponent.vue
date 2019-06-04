<template>
    <div>
        <saison-select ></saison-select>
        <b-table
                id="table-transition-example"
                :items="filteredequipes"
                :fields="fields"
                striped
                small
                primary-key="a"
                :tbody-transition-props="transProps"
        >
            <template slot="top-row" slot-scope="{ fields }">
                <td v-for="field in fields" :key="field.key">
                    <input v-model="filters[field.key]" :placeholder="field.label">
                </td>
            </template>

            <span slot="problemes" slot-scope="data" >

                <b-button variant="danger" v-for="(prob, index) in data.value">{{index}}</b-button>
                <h1 v-for="(prob, index) in data.value">{{index}}</h1>
            </span>

            <span slot="niveau_libelle" slot-scope="data" v-html="data.value"></span>

            <span slot="genre_libelle" slot-scope="data" v-html="data.value"></span>



            <span slot="url" slot-scope="data" >
                <a :href="'/admin/gymnastes/'+ data.item.id">Consulter</a>
            </span>

            <span slot="nbgyms" slot-scope="data" ><b-button>{{data.value.length}}</b-button></span>


        </b-table>
        {{equipes}}
    </div>
</template>

<script>

    export default {
        name: "equipeTableComponent"

        ,
        props:{
            debug:{
                type: Boolean,
                default:true
            }
        },
        methods: {

            toggle(form){
                console.log(form);
            },

            update: function() {
                axios
                    .get('/api/admin/equipes')
                    .then(response => (this.equipes = response.data));

            },




        },

        data() {
            return {

                equipes: [],
                filters: {
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                },
                fields: [
                    {
                        key: 'id',
                        sortable: true
                    },
                    {
                        key: 'nom',
                        label: 'Nom',
                        sortable: true
                    },
                    {
                        key: 'niveau_libelle',
                        label: 'Niveau',
                        sortable: true
                    },
                    {
                        key: 'nbgyms',
                        label: 'Effectif',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    },
                    {
                        key: 'niveaux',
                        label: 'Equipes',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    },
                    {
                        key: 'genre_libelle',
                        label: 'Genre',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    }
                                        ,
                    {
                        key: 'url',
                        label: 'Consulter',

                        // Variant applies to the whole column, including the header and footer

                    }
                ],

            }
        },

        mounted(){
            this.update();
        },

        computed: {
            filteredequipes () {
                const filtered = this.equipes.filter(item => {
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