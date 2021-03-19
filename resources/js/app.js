

import Vue from "vue";

require('./bootstrap');

window.Vue = require('vue').default;


//Home Page
Vue.component('home', require('./components/Home.vue').default);
Vue.component('home-login', require('./components/HomeLogin.vue').default);
Vue.component('navbarLogin', require('./components/NavbarLogin.vue').default);
Vue.component('contact-form', require('./components/ContactForm.vue').default);

//Add degree page
Vue.component('api-degree', require('./components/ApiDegree.vue').default);
Vue.component('navbar-add-degree', require('./components/NavbarAddDegree.vue').default);


Vue.component('alert', require('./components/Alert').default);
Vue.component('survey', require('./components/Survey').default);
Vue.component('survey-app', require('./components/SurveyApp').default);
Vue.component('survey-start', require('./components/SurveyStart').default);
Vue.component('survey-results', require('./components/SurveyResults').default);
Vue.component('degrees', require('./components/Degrees.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('register', require('./components/Register.vue').default);
Vue.component('degree-details', require('./components/DegreeDetails.vue').default);
Vue.component('scale', require('./components/Scale.vue').default);
Vue.component('salary', require('./components/Salary.vue').default);


const app = new Vue({
    el: '#app',
});
