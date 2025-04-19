//Importação de bibliotecas
import { createRouter, createWebHistory } from 'vue-router';

// Definição das rotas
const router = createRouter({

  // Definição do histórico de navegação
  history: createWebHistory(import.meta.env.BASE_URL),

  // Definição das rotas
  routes: [
    {
      path: '/',
      name: 'users',
      component: () => import('../views/users/index.vue'),
    },
    {
      path: '/users/form',
      name: 'users.form',
      component: () => import('../views/users/form.vue'),
    },
    {
      path: '/habits',
      name: 'habits',
      component: () => import('../views/habits/index.vue'),
    },
    {
      path: '/habits/form/:id',
      name: 'habits.form',
      component: () => import('../views/habits/form.vue'),
    },
    {
      path: '/situations',
      name: 'situations',
      component: () => import('../views/situations/index.vue'),
    },
    {
      path: '/situations/form',
      name: 'situation.form',
      component: () => import('../views/situations/form.vue'),
    },
    {
      path:'/categories',
      name:'categories',
      component: () => import('../views/categories/index.vue'),
    },
    {
      path:'/categories/form',
      name:'categories.form',
      component: () => import('../views/categories/form.vue'),
    },
    {
      path:'/groups',
      name:'groups',
      component: () => import('../views/groups/index.vue'),
    },
    {
      path:'/groups/form',
      name:'groups.form',
      component: () => import('../views/groups/form.vue'),
    },
    {
      path:'/types',
      name:'types',
      component: () => import('../views/types/index.vue'),
    },
    {
      path:'/types/form',
      name:'types.form',
      component: () => import('../views/types/form.vue'),
    }

  ],

});

export default router;
