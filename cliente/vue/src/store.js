import Vue from 'vue';
import Vuex from 'vuex';

import app from '@/core/store/app/';
import Autenticacao from '@/modules/Autenticacao/store/';
import Inscricao from '@/modules/Inscricao/store/';
import Administrativo from '@/modules/Administrativo/store/';
import shared from '@/modules/shared/store/';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    app,
    Autenticacao,
    Inscricao,
    Administrativo,
    shared
  },
  getters: {
    route: state => state.route,
  },
  strict: process.env.NODE_ENV !== 'production',
});
