<template>
    <div>

        <saison-select v-if="equipe_id == Null"></saison-select>
        <!--<button v-on:click="togglephotos" class="btn" v-bind:class="{'btn-primary': withphotos,'btn-secondary': !withphotos}">Photos</button>-->
        <!--<button v-on:click="togglehoraires" class="btn" v-bind:class="{'btn-primary': withhoraires,'btn-secondary': !withhoraires}">Horaires</button>-->
        {{filteredgyms.length}} Gymnastes
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
            <span slot="nom" slot-scope="data" >
                <a :href="'/admin/gymnastes/'+ data.item.id">{{data.value}}</a>
            </span>

            <template slot="top-row" slot-scope="{ fields }">
                <td v-for="field in fields" :key="field.key">
                    <input v-model="filters[field.key]" :placeholder="field.label">
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
        <span v-if="debug">{{gyms}}</span>
    </div>
</template>

<script>

    export default {
        name: "gymnastesTableComponent"

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
                    .get('/api/admin/gymnastes/saison/'+this.saison_id+"/quick")
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