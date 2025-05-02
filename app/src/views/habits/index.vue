<template>

  <div class="card-body">

    <div class="d-flex justify-content-between align-items-start">

      <div class="fs-3 fw-medium">

        Atividades de Hoje -

        <span class="badge bg-secondary">

          {{ data.length }}

        </span>

      </div>

      <RouterLink to="/habits/form/0" class="btn btn-secondary btn-sm">

        📅 Formulário

      </RouterLink>

    </div>

    <hr>

    <div class="form-check" v-for="(habit, index) in data" :key="index">

      <input class="form-check-input" type="checkbox" :id="'check' + index" @click="saveReadyOrNot(habit.habit_id)" :checked="habit.situation_id == 1">
      <label class="form-check-label" :for="'check' + index">

        <span class="fw-medium">

          {{ habit.name }}

        </span>

        <br>

        <span class="fw-lighter text-muted">

          {{ habit.description }}

        </span>

      </label>

    </div>

  </div>

</template>

<script setup>

// Importação de componentes e bibliotecas
import { ref, onMounted } from 'vue';
import { apiRequest } from '@/utils/api';

// Definição de variáveis reativas
const data = ref([]);
const ready = ref([]);
const groups = ref([]);

// Função executada quando o componente é motado
onMounted(async () => {

  try {

    // Guarda os dados da consulta
    data.value = await apiRequest({ 'request': { 'path': 'action/habits/habits_list', 'method': 'post' } });

    // Consulta todos os grupos de hábitos
    groups.value = await apiRequest({ 'request': { 'path': 'action/groups/groups_list', 'method': 'post' } });

    for (let i = 0; i < data.value.length; i++) {

      if (data.value[i].situation_id == 1) {

        console.log('situation_id', data[i].situation_id);
        ready.value.push(1);

      }

    }

  }
  catch (error) {

    // Exibe o erro no console
    console.error('Erro ao buscar dados:', error);

  }

})

async function deleteHabit(habit_id) {

  await apiRequest({
    'request': { 'path': 'action/habits/habits_delete', 'method': 'post', 'data': { 'habit_id': habit_id } }
  })

    .then((response) => {

      console.log('Resposta:', response);

    })

    .catch((error) => {

      console.error('Erro:', error);

    });

}

async function saveReadyOrNot(habit_id) {

  await apiRequest({
    'request': { 'path': 'action/habits/habits_save_ready_or_not', 'method': 'post', 'data': { 'habit_id': habit_id } }
  })

    .then((response) => {

      console.log('Resposta:', response);

    })

    .catch((error) => {

      console.error('Erro:', error);

    })

};

</script>
