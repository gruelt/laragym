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
                        <th>Photo</th>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Date Naissance</th>
                        <th>Equipe</th>
                        <th></th>
                    </tr>
                    </thead>

                    <tbody>





                    <tr v-for="gym in gyms">
                        <!-- ID -->
                        <td style="vertical-align: middle;">
                            {{ gym.id }}
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
                            {{ gym.date_naissance}}
                        </td>

                        <td v-html="gym.niveaux" style="vertical-align: middle;">

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
            gyms: []
        }
    }
</script>

<style scoped>

</style>