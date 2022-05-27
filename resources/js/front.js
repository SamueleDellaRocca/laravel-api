/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
// const { default: Axios } = require('axios');
import './bootstrap';
window.Vue = require('vue');
window.Axios = require('axios');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueRouter from 'vue-router';
import App from './views/App.vue';
import Vue from 'vue';

import PageHome from './pages/PageHome.vue';
import PageAbout from './pages/PageAbout.vue';
import PostIndex from './pages/PostIndex.vue';
import PostShow from './pages/PostShow.vue';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: PageHome,
        },
        {
            path: '/about',
            name: 'about',
            component: PageAbout,
        },
        {
            path: '/blog',
            name: 'postIndex',
            component: PostIndex,
        },
        {
            path: '/blog/:slug',
            name: 'postshow',
            component: PostShow,
        },
    ],
});


const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
});