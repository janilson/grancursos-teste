import Vue from 'vue';
import Vuex from 'vuex';

import GranCursos from './Modules/GranCursos/store/';
import shared from './Modules/shared/service/store/';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    GranCursos,
    shared
  },
  strict: process.env.NODE_ENV !== 'production',
});
