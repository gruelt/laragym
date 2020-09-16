<template>
    <div class="container">
<!--        Selected : {{selected}}-->
        <button v-on:click="togglehoraires" class="btn" v-bind:class="{'btn-primary': withhoraires,'btn-secondary': !withhoraires}">Affichage Horaires</button>
        <b-table striped hover small :items="filteredequipes" :fields="fields">

            <template slot="top-row" slot-scope="{ fields }">
                <td v-for="field in fields" :key="field.key">
                    <input  size=3 v-model="filters[field.key]" :placeholder="field.label">
                </td>
            </template>

                 <span slot="url" slot-scope="data" >

                    <section v-if="selected.includes(data.item.id)">
                    <b-button v-if="selected.includes(data.item.id)"  @click="remove(data.item.id)" variant="danger">-</b-button>
                    <b-badge variant="success">Membre</b-badge>
                        </section>

                     <section v-else>
                    <b-button  @click="add(data.item.id)">+</b-button>



</section>

                </span>

                <span slot="niveau_libelle" slot-scope="data" v-html="data.value"></span>

                <span slot="genre_libelle" slot-scope="data" v-html="data.value"></span>

                <span slot="horaires" slot-scope="data" >
                    <b-list-group>
                    <b-list-group-item v-if="withhoraires" v-for="horaire in data.value">{{horaire.jour.nom_jour}} : {{horaire.heure_debut}}h{{horaire.minute_debut}} / {{horaire.heure_fin}}h{{horaire.minute_fin}}</b-list-group-item>

                    </b-list-group>
                </span>

            <span slot="nbgyms_count" slot-scope="data" >
                    <b-badge v-if="data.item.nbgyms_count < 8" variant="success">{{data.item.nbgyms_count}}</b-badge>
                    <b-badge v-if="data.item.nbgyms_count >= 8 && data.item.nbgyms_count < 10 " variant="warning">{{data.item.nbgyms_count}}</b-badge>
                                        <b-badge v-if="data.item.nbgyms_count >= 10 " variant="danger">{{data.item.nbgyms_count}}</b-badge>

            </span>






        </b-table>





    </div>
</template>

<script>
    export default {

        mounted() {
            console.log('Component mounted.')
        },
        props:{
          gymnaste_id:"",
            saison_id:""
        },
        methods: {
            togglehoraires(){
                this.withhoraires = ! this.withhoraires;
            },
            getselected: function() {
                axios
                    .get('/api/admin/gymnastes/'+this.gymnaste_id+'/saison/'+ this.saison_id +'/equipes')
                    .then(response => (this.selected = response.data));

            },
            getlist: function() {
                axios
                    .get('/api/admin/equipes/saison/'+this.saison_id+"")
                    .then(response => (this.options = response.data));

            },
            save: function(){
                axios
                    .post('/api/admin/gymnastes/'+this.gymnaste_id+'/saison/'+ this.saison_id +'/equipes',{ equipes: this.selected });



            },
            //ajoute l'affectation de l'equpe et sauve
            add: function(id_equipe){
                this.selected.push(id_equipe);
                this.save();

            }

            ,
            //enleve l'affectation de l'equpe et sauve
            remove: function(id_equipe){
                const index = this.selected.indexOf(id_equipe);
                if (index > -1) {
                    this.selected.splice(index, 1);
                }

                this.save();

            }

            ,

            reload: function(){
                location.reload();
            }



        },

        data() {
            return {
                filters: {
                    id: '',
                    issuedBy: '',
                    issuedTo: ''
                },
                withhoraires:false,
                fields: [
                    // {
                    //     key: 'id',
                    //     sortable: true
                    // },


                    {
                        key: 'url',
                        label: 'Affectation',

                        // Variant applies to the whole column, including the header and footer

                    },
                    {
                        key: 'nbgyms_count',
                        label: 'Effectif',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

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
                        key: 'categorie',
                        label: 'Catégorie',
                        sortable: true
                    },



                    {
                        key: 'genre_libelle',
                        label: 'Genre',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    }
                    ,
                    // {
                    //     key: 'coach',
                    //     label: 'Coach',
                    //     sortable: true,
                    //     // Variant applies to the whole column, including the header and footer
                    //
                    // },
                    {
                        key: 'horaires',
                        label: 'Horaires',
                        sortable: true,
                        // Variant applies to the whole column, including the header and footer

                    }

                ],
                selected: null,
                options: [
                    { value: null, text: 'Chargement en cours' },

                ]
            }
        },

        mounted(){

        },
        watch: {
            saison_id: function (val) {
                this.getselected();
                this.getlist();

            },
            selected: function(val){
                //this.save();
            }

        },
        computed: {
            filteredequipes () {
                const filtered = this.options.filter(item => {
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
