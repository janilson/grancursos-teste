import {DefaultLayout} from '@/core/components/layouts';


export default [
  {
    path: '/administrativo',
    component: DefaultLayout,
    meta: {title: 'Administrativo'},
    redirect: '/lista-adesoes',
    hidden: true,
    children: [
      {
        path: '/lista-representantes',
        name: 'lista-representantes',
        meta: {title: 'Representantes', public: false},
        component: () => import(/* webpackChunkName: "conta-autenticar" */ '@/modules/Administrativo/views/Representantes.vue'),
      },
      {
        path: '/lista-adesoes',
        name: 'lista-adesoes',
        meta: {title: 'Adesões', public: false},
        component: () => import(/* webpackChunkName: "conta-autenticar" */ '@/modules/Administrativo/views/Adesoes.vue'),
      },
      {
        path: '/lista-inscritos',
        name: 'lista-inscritos',
        meta: {title: 'Inscritos', public: false},
        component: () => import(/* webpackChunkName: "conta-autenticar" */ '@/modules/Administrativo/views/Inscritos.vue'),
      },
      {
        path: '/lista-classificados',
        name: 'lista-classificados',
        meta: {title: 'Classificados', public: false},
        component: () => import(/* webpackChunkName: "conta-autenticar" */ '@/modules/Administrativo/views/Classificados.vue'),
      }
    ],
  }
];
