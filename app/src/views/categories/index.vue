<template>

  <div class="card-body">

    <h1>

      Categorias/

      <RouterLink to="/categories/form" class="btn btn-primary">
        Formulário
      </RouterLink>

    </h1>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nome</th>
          <th scope="col">Email</th>
          <th scope="col">Operações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(category, index) in data" :key="category.category_id">
          <th scope="row">
            {{ category.category }}
          </th>
          <td>
            {{ category.name }}
          </td>
          <td>
            {{ category.description }}
          </td>
          <td>
            @mdo
          </td>
        </tr>
      </tbody>
    </table>

  </div>

</template>

<script setup>

// Importação de componentes e bibliotecas
import { ref, onMounted } from 'vue';
import { apiRequest } from '@/utils/api';

// Definição de variáveis reativas
const data = ref([]);

// Função executada quando o componente é motado
onMounted(async () => {

  try {

    // Guarda os dados da consulta
    data.value = await apiRequest({ 'request': { 'path': 'action/categories/categories_list', 'method': 'post' } });

  }
  catch (error) {

    // Exibe o erro no console
    console.error('Erro ao buscar dados:', error);

  }

})

</script>
