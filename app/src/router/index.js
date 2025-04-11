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
      name: 'habitos',
      component: () => import('../views/habits/index.vue'),
    },

  ],

});

export default router;
