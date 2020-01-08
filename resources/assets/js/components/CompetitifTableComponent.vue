<template>
    <div>
        <saison-select ></saison-select>
        <!--<button v-on:click="togglephotos" class="btn" v-bind:class="{'btn-primary': withphotos,'btn-secondary': !withphotos}">Photos</button>-->
<!--        <button v-on:click="togglehoraires" class="btn" v-bind:class="{'btn-primary': withhoraires,'btn-secondary': !withhoraires}">Affichage Horaires</button>-->



        <b-table
            id="table-transition-example"
            :items="filteredequipes"
            :fields="fields"
            striped
            small
            responsive

            primary-key="a"
            :tbody-transition-props="transProps"
        >
            <template slot="top-row" slot-scope="{ fields }">
                <td v-for="field in fields" :key="field.key">
                    <input v-model="filters[field.key]" :placeholder="field.label">
                </td>
            </template>

            <span slot="problemes" slot-scope="data" >

                <b-button variant="danger" v-for="(prob, index) in data.value" :key="index">{{index}}</b-button>
                <h1 v-for="(prob, index) in data.value">{{index}}</h1>
            </span>

            <span slot="niveau_libelle" slot-scope="data" v-html="data.value"></span>

            <span slot="genre_libelle" slot-scope="data" v-html="data.value"></span>
            <span slot="nom" slot-scope="data" >
                <a :href="'/admin/competitifs/'+ data.item.id">{{data.value}}</a>
            </span>




            <span slot="url" slot-scope="data" >
                <a :href="'/admin/competitifs/'+ data.item.id">Consulter</a>
            </span>

            <span slot="nbgyms_count" slot-scope="data">{{data.value}}
                <b-progress :value="data.value" :max="data.item.niveau.nb_gyms" show-progress animated ></b-progress>

                <b-badge v-if="data.value<data.item.niveau.nb_notes"pill variant="danger">Minimum {{data.item.niveau.nb_notes}} </H5>
                    Gyms</b-badge>
                                        <b-badge v-if="data.value<data.item.niveau.nb_gyms"pill variant="info">Possibilité {{data.item.niveau.nb_gyms}} </H5>
                                            Gyms</b-badge>

                <b-badge v-if="data.value>data.item.niveau.nb_gyms"pill variant="warning">Possibilité {{data.item.niveau.nb_gyms}} </H5>
                    Gyms</b-badge>

                <!--<b-progress :value="data.value" max="10" show-progress animated ></b-progress>-->
                <!--<b-button class="btn-warning" v-if="data.value >= 6 && data.value < 10">-->
                <!--<b-button class="btn-warning" v-if="data.value == 10">Complet!</b-button>-->
                <!--<b-button class="btn-warning" v-if="data.value > 10">Surchargé !</b-button>-->


            </span>
            <span slot="coach" slot-scope="data" v-html="data.value"></span>

            <span slot="categorie" slot-scope="data" ><b-button>{{data.value}}</b-button></span>
            <span slot="filiere" slot-scope="data" >{{data.value}}</span>


        </b-table>{{equipes}}

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
            togglehoraires(){
                this.withhoraires = ! this.withhoraires;
            },

            update: function() {
                axios
                    .get('/api/admin/competitifs/saison/'+this.saison_id)
                    .then(response => (this.equipes = response.data));

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




        },

        data() {
            return {
                withhoraires:false,
                autoupdate:true,
                saison_id: "9999",
                equipes: [],
                filters: {
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                },
                fields: [
                    // {
                    //     key: 'id',
                    //     sortable: true
                    // },
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
                        key: 'categorie',
                        label: 'Catégorie',
                        sortable: true
                    },
                    {
                        key: 'filiere',
                        label: 'Filière',
                        sortable: true
                    },
                    {
                        key: 'nbgyms_count',
                        label: 'Effectif',
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
                        key: 'coach',
                        label: 'Coach',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    },

                    {
                        key: 'url',
                        label: 'Consulter',

                        // Variant applies to the whole column, including the header and footer

                    }
                ],

            }
        },

        mounted(){
            this.getcurrentseason();

            this.update();

            this.interval = setInterval(function () {
                if(this.autoupdate==true ) {

                    this.update();

                }
            }.bind(this),  6000);

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
