import Vue from 'vue';
import App from './App';
import router from './router/index';
import store from './store';
import './registerServiceWorker';
import vuetify from '@/core/plugins/vuetify';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import SCardConteudo from '@/core/components/card/CardConteudo';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

Vue.config.productionTip = false;

Vue.component('s-card-conteudo', SCardConteudo);

library.add(fas);

Vue.component('font-awesome-icon', FontAwesomeIcon);

new Vue({
  router,
  store,
  vuetify,
  render: h => h(App),
}).$mount('#app');
