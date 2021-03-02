

require('./bootstrap');

window.Vue = require('vue').default;


//Home Page
Vue.component('home', require('./components/Home.vue').default);
Vue.component('home-login', require('./components/HomeLogin.vue').default);
Vue.component('navbarLogin', require('./components/NavbarLogin.vue').default);

//Add degree page
Vue.component('api-degree', require('./components/ApiDegree.vue').default);
Vue.component('navbar-add-degree', require('./components/NavbarAddDegree.vue').default);


Vue.component('degrees', require('./components/Degrees.vue').default);
Vue.component('login', require('./components/Login.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('register', require('./components/Register.vue').default);
Vue.component('error-message', require('./components/Alert.vue').default);


const app = new Vue({
    el: '#app',
});