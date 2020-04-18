/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**  
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('getal-cirkel', require('./components/GetalCirkel.vue').default);
Vue.component('vraagformulier', require('./components/VraagFormulier.vue').default);
Vue.component('mutformulier', require('./components/MutFormulier.vue').default);
Vue.component('code-formulier', require('./components/CodeFormulier.vue').default);
Vue.component('intake-formulier', require('./components/IntakeFormulier.vue').default);
Vue.component('kamerformulier', require('./components/KamerFormulier.vue').default);
Vue.component('file-upload', require('./components/FileUpload.vue').default);  
Vue.component('calendar-component', require('./components/Calendar.vue').default);
Vue.component('boekhouding', require('./components/Boekhouding.vue').default);
// Vue.component('factuur', require('./components/Factuur.vue').default);
Vue.component('algemeen', require('./components/Algemeen.vue').default);
Vue.component('klantgegevens', require('./components/Klantgegevens.vue').default);
Vue.component('contactpersoon', require('./components/Contactpersoon.vue').default);
Vue.component('vragentypeformulier', require('./components/Vragentypeformulier.vue').default);
Vue.component('klantvraag', require('./components/Klantvraag.vue').default);
Vue.component('vraagantwoord', require('./components/Vraagantwoord.vue').default);
Vue.component('hotelreservatie', require('./components/Hotelreservatie.vue').default);
Vue.component('adminhotelreservatiewijzig', require('./components/Adminhotelreservatiewijzig.vue').default);
Vue.component('reservatie', require('./components/Reservatie.vue').default);
Vue.component('factuuradres', require('./components/FactuurAdres.vue').default);
Vue.component('client', require('./components/Client.vue').default);
Vue.component('cp', require('./components/Cp.vue').default);
Vue.component('hotelfiche', require('./components/HotelFiche.vue').default);
Vue.component('wijzigformulier', require('./components/WijzigFormulier.vue').default);
/*     
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
     
   methods:{
       vermelden(param){
          url = 'https://vleugels.test';
          console.log("hier  kom je terecht bij vermelden - app.js");
          if (param){
              loc = url + '/' + param.message;
               console.log("loc = " + loc);
               window.location.href = loc; 
          }
          window.location = url;
       },
         
   }
});

Vue.config.devtools = true;
/*const getalcirkel = new Vue({
    el: '#mijn-card',
    
});*/


