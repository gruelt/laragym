<template>
    <div>
        <div class="card card-default">
            <div class="card-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Mes Inscrits
                    </span>


                </div>
            </div>

            <div class="card-body">
                <!-- Current Clients -->
                <!--<p class="mb-0" v-if="clients.length === 0">-->
                <!--You have not created any OAuth clients.-->
                <!--</p>-->

                <table class="table table-borderless mb-0" >
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Date Naissance</th>
                        <th>Equipe</th>
                        <th>Statut</th>
                        <th>Inscription</th>

                        <th></th>
                    </tr>
                    </thead>

                    <tbody>





                    <tr v-for="gym in gyms">
                        <!-- ID -->
                        <td style="vertical-align: middle;">
                        {{ gym.id }}
                        </td>
                        <td style="vertical-align: middle;">

                            <img v-if="gym.photo" :src="gym.photo_url"  width="120" height="160" alt="">
                            <img v-else src="/images/anonym.jpg" alt="" width="120" height="160">


                        </td>

                        <!-- Name -->
                        <td style="vertical-align: middle;">
                            {{ gym.nom }}
                        </td>

                        <!-- Secret -->
                        <td style="vertical-align: middle;">
                            {{ gym.prenom}}
                        </td>

                        <td style="vertical-align: middle;">
                            {{ gym.date_naissance_fr}}
                        </td>

                        <td v-html="gym.niveaux" style="vertical-align: middle;">

                        </td>

                        <td >
                            <span v-for="(probleme, index) in gym.problemes" variant="light" v-bind:key="probleme">

                                        <b-badge  v-for="(subprobleme, index2) in probleme" :variant="subprobleme.class" :key="subprobleme">{{subprobleme.text}}</b-badge><br>
                                    </span>
                        </td>

                        <td  style="vertical-align: middle;">
                                <div class="list-group" >

                                    <li class="list-inline" v-for="saison in gym.saisons ">
                                        <b-button v-if="saison.pivot.complet ==1"  variant="success">
                                            {{saison.nom}} <b-badge variant="light">Complet</b-badge>
                                        </b-button>
                                        <b-button v-else  variant="info">
                                            {{saison.nom}} <b-badge variant="light">Préinscrit</b-badge>
                                        </b-button>

                                    </li>



                                </div>
                            <b-button v-if="gym.reinscrit.statut ==0 && gym.reinscrit.saison !=0 " :href="'/responsable/gymnaste/' + gym.id +'/reinscrire/'+ gym.reinscrit.saison.id" variant="warning">
                                + Re-inscrire pour {{gym.reinscrit.saison.nom}}
                            </b-button>
                        </td>

                        <!-- Delete Button -->
                        <td style="vertical-align: middle;">
                            <a :Href="'/responsable/gymnastes/'+gym.id">
                                Consulter
                            </a>
                        </td>
                    </tr>












                    </tbody>
                </table>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "UserCardComponent",
        props:{
            gyms:{}
        }
    }
</script>

<style scoped>

</style>