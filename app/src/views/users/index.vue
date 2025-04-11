<template>

  <div>

    <h1>

      Usuários/ 
      
      <RouterLink to="/users/form" class="btn btn-primary">
        Formulário
      </RouterLink>

    </h1>

    {{ data }}

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
    data.value = await apiRequest('action/users/users_list')

  } catch (err) {

    // Em caso de erro escreve no console
    console.error('Erro ao carregar usuários:', err)

  }

})
</script>
