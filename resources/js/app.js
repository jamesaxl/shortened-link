require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './router/index';
import store from './store/index';
import App from './App.vue';
import Axios from './axios';
import Routing from './routing';
import VueI18n from 'vue-i18n';
import {messages} from './translations';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(Axios);
Vue.use(VueI18n)
Vue.use(Routing);

const i18n = new VueI18n({
    locale: 'en',
    messages,
});

store.dispatch('auth/initStore').then();

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    components: { App }
});
