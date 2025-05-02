<template>

  <div class="card-body">

    <h1>

      Grupos/

      <RouterLink to="/groups/form/0" class="btn btn-primary">
        Formulário
      </RouterLink>

    </h1>

    <div class="card">

      <table class="table">

        <thead>

          <tr>

            <th scope="col">

              #

            </th>

            <th scope="col">

              Icone

            </th>

            <th scope="col">

              Nome

            </th>

            <th scope="col" class="text-center">

              Operações

            </th>

          </tr>

        </thead>

        <tbody>

          <tr v-for="(group, index) in data" :key="group.group_id">

            <th scope="row">

              {{ group.group_id }}

            </th>

            <td>

              {{ group.preferences }}

            </td>

            <td>

              {{ group.name }}

            </td>

            <td class="text-center">

              <div class="dropdown">

                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                  Dropdown button

                </button>

                <ul class="dropdown-menu">

                  <li>

                    <RouterLink :to="{ name: 'groups.form', params: { id: group.group_id } }" class="dropdown-item" href="#">

                      Editar

                    </RouterLink>

                  </li>

                  <li>

                    <a class="dropdown-item" href="#">Another action</a>

                  </li>

                </ul>

              </div>

            </td>

          </tr>

        </tbody>

      </table>

    </div>

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
    data.value = await apiRequest({ 'request': { 'path': 'action/groups/groups_list', 'method': 'post' } });

  }
  catch (error) {

    // Exibe o erro no console
    console.error('Erro ao buscar dados:', error);

  }

})

</script>
