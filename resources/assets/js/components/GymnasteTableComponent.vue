<template>
    <div>
        <saison-select ></saison-select>
        {{saison_id}}
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
                    <input v-model="filters[field.key]" :placeholder="field.label">
                </td>
            </template>

            <span slot="problemes" slot-scope="data" >

                <b-button variant="danger" v-for="(prob, index) in data.value">{{index}}</b-button>
                <h1 v-for="(prob, index) in data.value">{{index}}</h1>
            </span>

            <span slot="niveaux" slot-scope="data" v-html="data.value"></span>



            <span slot="url" slot-scope="data" >
                <a :href="'/admin/gymnastes/'+ data.item.id">Consulter</a>
            </span>


        </b-table>
        {{gyms}}
    </div>
</template>

<script>

    export default {
        name: "gymnastesTableComponent"

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
                    .get('/api/admin/gymnastes/saison/'+this.saison_id)
                    .then(response => (this.gyms = response.data));

            },
            updatesaison(saison_id) {
                this.saison_id = saison_id;
                this.update();
            }




        },

        data() {
            return {
                saison_id: "9999",
                gyms: [],
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
                        key: 'prenom',
                        label: 'Prénom',
                        sortable: true
                    },
                    {
                        key: 'age',
                        label: 'Age',
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
                        key: 'problemes_short',
                        label: 'Problèmes',
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