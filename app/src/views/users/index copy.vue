<template>
    <div>
      <h1>Usuários</h1>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { fetch } from '@/stores/store.js'
  
  const usuarios = ref([])
  const erro = ref(null)
  
  onMounted(async () => {
    const resposta = await fetch('action/users/users_list');
  
    if (resposta.erro) {
      erro.value = resposta.mensagem
    } else {
      usuarios.value = resposta;
      console.log('Usuários carregados:', usuarios.value);
    }
  })
  </script>
  