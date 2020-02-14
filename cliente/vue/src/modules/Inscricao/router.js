import {DefaultLayout} from '@/core/components/layouts';

export default [
  {
    path: '/inscricao',
    component: DefaultLayout,
    meta: {title: 'Inscrição'},
    redirect: '/lista-inscricao',
    hidden: true,
    children: [
      {
        path: '/lista-inscricao',
        name: 'lista-inscricao',
        meta: {title: 'Inscrições', public: false},
        component: () => import(/* webpackChunkName: "conta-autenticar" */ '@/modules/Inscricao/views/Inscricao.vue'),
      },
      {
        path: '/lista-historico',
        name: 'lista-historico',
        meta: {title: 'Históricos', public: false},
        component: () => import(/* webpackChunkName: "conta-autenticar" */ '@/modules/Inscricao/views/Historico.vue'),
      },
    ],
  }
];
