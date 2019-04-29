<template>
    <div>
        <div>
            <div class="card card-default">
                <div class="card-header">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        OAuth Clients {{this.gyms}} zz {{test}}
                    </span>

                        <a class="action-link" tabindex="-1" >
                            Create New Client
                        </a>
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
                            <th>Client ID</th>
                            <th>Name</th>
                            <th>Secret</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

    </div>
    </div>
</template>

<script>
    export default {
        name: "gymnastesCardComponent"

    ,
    methods: {

        toggle(form){
            console.log(form);
        },

        update: function() {
            axios
                .get('/api/responsables/gymnastes')
                .then(response => (this.gyms = response.data));

        },




    },

        data() {
            return {

                gyms: 'rien',
                test: 'qqch'

            }
        },

    mounted(){
        this.update();
    }

    }
</script>

<style scoped>

</style>