import { DefaultLayout } from '@/core/components/layouts';
import RoutersLogin from '@/modules/Autenticacao/router';
import RoutersInscricao from '@/modules/Inscricao/router';
import RoutersAdministrativo from '@/modules/Administrativo/router';

export default [
  ...RoutersLogin,
  ...RoutersInscricao,
  ...RoutersAdministrativo,
  {
    path: '/',
    component: DefaultLayout,
    meta: { title: '', group: 'apps', icon: '' },
     redirect: '/login',
    children: [
      {
        path: '/home',
        name: 'Dashboard',
        meta: {
          title: '', group: 'apps', icon: 'dashboard',
        },
        component: () => import(/* webpackChunkName: "dashboard" */ '@/core/views/Dashboard.vue'),
      },
    ],
  },

  // list
  // {
  //   path: '/cms',
  //   component: DefaultLayout,
  //   redirect: '/cms/table',
  //   meta: { title: 'CMS', icon: 'view_compact', group: 'cms' },
  //   children: [
  //     {
  //       path: '/cms/table',
  //       name: 'ListTable',
  //       meta: { title: 'CMS Table' },
  //       component: () => import(/* webpackChunkName: "table" */ '@/core/views/list/Table.vue'),
  //     },
  //   ],
  // },

];
