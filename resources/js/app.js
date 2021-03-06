/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('home', require('./components/Home.vue').default);
Vue.component('home-login', require('./components/HomeLogin.vue').default);
Vue.component('navbarLogin', require('./components/NavbarLogin.vue').default);
Vue.component('contact-form', require('./components/ContactForm.vue').default);
Vue.component('degrees', require('./components/Degrees.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('register', require('./components/Register.vue').default);
Vue.component('error-message', require('./components/Alert.vue').default);
Vue.component('degree-details', require('./components/DegreeDetails.vue').default);
Vue.component('scale', require('./components/Scale.vue').default);
Vue.component('salary', require('./components/Salary.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
