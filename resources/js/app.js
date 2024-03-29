

import Vue from "vue";
import moment from "moment";
import FlashMessage from '@smartweb/vue-flash-message';
Vue.prototype.moment = moment

Vue.use(FlashMessage);
Vue.config.productionTip = false;


require('./bootstrap');
window.Vue = require('vue').default;


//Saved Session
Vue.component('load-session', require('./components/LoadSavedSession.vue').default);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('User', require('./components/User.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);

//Dashboard:
Vue.component('student-dashboard', require('./components/StudentDashboard.vue').default);
Vue.component('admin-dashboard', require('./components/AdminDashboard.vue').default);
Vue.component('import-college-api', require('./components/ImportCollegeAPI').default);



//Home Page
Vue.component('home', require('./components/Home.vue').default);
Vue.component('home-login', require('./components/HomeLogin.vue').default);
Vue.component('navbarLogin', require('./components/NavbarLogin.vue').default);
Vue.component('contact-form', require('./components/ContactForm.vue').default);

//Add degree page
Vue.component('api-degree', require('./components/ApiDegree.vue').default);
Vue.component('navbar-add-degree', require('./components/NavbarAddDegree.vue').default);


Vue.component('alert-message', require('./components/AlertMessage').default);
Vue.component('survey', require('./components/Survey').default);
Vue.component('survey-app', require('./components/SurveyApp').default);
Vue.component('survey-start', require('./components/SurveyStart').default);
Vue.component('survey-results', require('./components/SurveyResults').default);
Vue.component('degrees', require('./components/Degrees.vue').default);
//Vue.component('login', require('./components/Login.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
//Vue.component('register', require('./components/Register.vue').default);
Vue.component('degree-details', require('./components/DegreeDetails.vue').default);
Vue.component('scale', require('./components/Scale.vue').default);
Vue.component('salary', require('./components/Salary.vue').default);


const app = new Vue({
    el: '#app',
});
