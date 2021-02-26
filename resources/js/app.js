/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import {createApp} from 'vue';

let app = createApp({});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

app.component('degrees', require('./components/Degrees').default);
app.component('login', require('./components/Login').default);
app.component('navbar', require('./components/Navbar').default);
app.component('register', require('./components/Register').default);
app.component('alert', require('./components/Alert').default);
app.component('survey', require('./components/Survey').default);
app.component('survey-app', require('./components/SurveyApp').default);
app.component('survey-results', require('./components/SurveyResults').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

app.mount('#app');
