<template>

  <div>

    <h1>

      Usuários/

      <RouterLink to="/users/form" class="btn btn-primary">
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
        <tr v-for="(user, index) in data" :key="user.id">
          <th scope="row">
            {{ user.user_id }}
          </th>
          <td>
            {{ user.name }}
          </td>
          <td>
            {{ user.email }}
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
import { ref, onMounted } from 'vue'
import { apiRequest } from '@/utils/api'

// Definição de variáveis reativas
const data = ref([])

// Função executada quando o componente é montado
onMounted(async () => {

  try {

    // Chamada à API para obter a lista de usuários
    data.value = await apiRequest({ 'request': { 'path': 'action/users/users_list', 'method': 'post' }});

  } catch (err) {

    // Em caso de erro escreve no console
    console.error('Erro ao carregar usuários:', err)

  }

})
</script>
