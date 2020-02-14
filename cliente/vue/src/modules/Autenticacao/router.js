import {AuthLayout} from '@/core/components/layouts';


export default [
  {
    path: '/login',
    component: AuthLayout,
    meta: {title: 'Login'},
    hidden: true,
    children: [
      {
        path: '/',
        name: 'login',
        meta: {title: 'Autenticar', public: true},
        component: () => import(/* webpackChunkName: "conta-autenticar" */ '@/modules/Autenticacao/views/Login.vue'),
      },
      {
        path: 'sair',
        name: 'login-sair',
        meta: {title: 'Sair do sistema', public: true},
        component: () => import(/* webpackChunkName: "login-sair" */ '@/modules/Autenticacao/views/Logout.vue'),
      },
      {
        path: 'recuperar-senha',
        name: 'login-recuperar-senha',
        meta: {title: 'Esqueci minha senha', public: true},
        component: () => import(/* webpackChunkName: "login-recuperar-senha" */ '@/modules/Autenticacao/views/RecuperacaoDeSenha.vue'),
      },
    ],
  }
];
