<template>

  <div>

    <h1>

      Hábitos/

      <RouterLink to="/habits/form" class="btn btn-primary">
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
        <tr v-for="(habit, index) in data" :key="habit.habit_id">
          <th scope="row">
            {{ habit.habit_id }}
          </th>
          <td>
            {{ habit.name }}
          </td>
          <td>
            {{ habit.description }}
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
    data.value = await apiRequest({ 'request': { 'path': 'action/habits/habits_list', 'method': 'post' } });

  }
  catch (error) {

    // Exibe o erro no console
    console.error('Erro ao buscar dados:', error);

  }

})

</script>
