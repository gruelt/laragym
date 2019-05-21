<template>
    <div>
        <b-table
                id="table-transition-example"
                :items="gyms"
                :fields="fields"
                striped
                small
                primary-key="a"
                :tbody-transition-props="transProps"
        >
            <span slot="niveaux" slot-scope="data" v-html="data.value"></span>
            <span slot="url" slot-scope="data" >
                <a :href="'admin/gymnastes/'+ data.item.id">Consulter</a>
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
                    .get('/api/admin/gymnastes')
                    .then(response => (this.gyms = response.data));

            },




        },

        data() {
            return {

                gyms: [],
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
                        label: '',
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
        }

    }

</script>

<style scoped>

</style>