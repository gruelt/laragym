
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */



require('./bootstrap');

window.Vue = require('vue');
//
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// Vue.component('sidebar', require('./components/layout/sidebarComponent.vue'));
// Vue.component('navbar', require('./components/layout/navbarComponent.vue'));



Vue.component('gymnastes-list', require('./components/GymnastesListComponent.vue'));

Vue.component('gymnaste-card', require('./components/GymnasteCardComponent.vue'));

Vue.component('gymnaste-info', require('./components/GymnasteInfoComponent.vue'));

Vue.component('gymnaste-table', require('./components/GymnasteTableComponent.vue'));

Vue.component('gymnaste-equipe', require('./components/GymnasteEquipeComponent.vue'));


Vue.component('equipe-table', require('./components/EquipeTableComponent.vue'));




Vue.component('saison-select', require('./components/SaisonSelectComponent.vue'));

Vue.component('passport-clients',require('./components/passport/Clients.vue'));

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue'));

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue'));





import Vue from 'vue';
/*import Vuetify from 'vuetify';

Vue.use(Vuetify);*/

import BootstrapVue from 'bootstrap-vue';

Vue.use(BootstrapVue);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


//Demo Gestion des Utilisateurs
//Vue.component('user-list', require('./components/users/UserListComponent.vue'));

import Datepicker from 'vuejs-datepicker';

import { fr } from 'vuejs-datepicker/dist/locale';



var app = new Vue({
    el: '#app',

    components: {
        Datepicker
    },
    data () {
        return {
            fr: fr,
            breadcrumb:['Accueil']

        }
    }

});


window.axios.defaults.headers.common = {

    'X-Requested-With': 'XMLHttpRequest'
};