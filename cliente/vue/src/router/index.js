import Vue from 'vue';
import Router from 'vue-router';
import NProgress from 'nprogress';
import appRoutes from './config';
import 'nprogress/nprogress.css';
import coreRoutes from '@/core/router';
import { obterInformacoesJWT } from '@/modules/shared/service/helpers/jwt';
import { eventHub } from '@/event';

const routes = coreRoutes.concat(appRoutes);

Vue.use(Router);

const router = new Router({
  mode: 'history',
  linkActiveClass: 'active',
  routes
});

const emitirMensagemErro = (mensagem) => {
  eventHub.$nextTick(() => {
    eventHub.$emit('eventoErro', mensagem);
  });
};

const isEmpty = string => (!string || string.length === 0);

router.beforeEach((to, from, next) => {
  NProgress.start();

  const authRequired = !to.meta.public || to.meta.public === false;
  const userToken = localStorage.getItem('user_token');
  const informacaoUsuario = obterInformacoesJWT(userToken);
  const tokenValida =!isEmpty(informacaoUsuario);

  try {
    if (!userToken && authRequired && to.path !== '/login') {
      NProgress.done();
      throw new Error('Acesso negado!');
    }

    if (userToken && authRequired && !tokenValida) {
      localStorage.removeItem('user_token');
      NProgress.done();
      throw new Error('Seu acesso expirou!');
    }

    if (informacaoUsuario.user && informacaoUsuario.user.tp_perfil === 'E' && to.path == '/home') {
      return router.push({ name: 'lista-inscricao' });
    }

    if (informacaoUsuario.user && informacaoUsuario.user.tp_perfil === 'I' && to.path == '/home') {
      return router.push({ name: 'lista-adesoes' });
    }

    return next();
  } catch (objEx) {
    emitirMensagemErro(objEx.message);
    return router.push('/login');
  }
});

router.afterEach(() => {
  NProgress.done();
});

export default router;
