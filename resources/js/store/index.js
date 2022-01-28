import Vue from 'vue';
import Vuex from 'vuex';
import mainStore from './store';
Vue.use(Vuex);

const store = new Vuex.Store(mainStore);

export default store;
