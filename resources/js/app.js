

require('./bootstrap');
window.Vue = require('vue').default;



Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('User', require('./components/User.vue').default);

Vue.component('home', require('./components/Home.vue').default);
Vue.component('navbar', require('./components/Navbar.vue').default);
Vue.component('home-login', require('./components/HomeLogin.vue').default);
Vue.component('contact-form', require('./components/ContactForm.vue').default);

//Dashborad:
Vue.component('student-dashboard', require('./components/StudentDashboard.vue').default);
Vue.component('admin-dashboard', require('./components/AdminDashboard.vue').default);





const app = new Vue({
    el: '#app',
});
