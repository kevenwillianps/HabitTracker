<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Menu from '@/layout/Menu.vue'; // quando for export default, usarm sem {}

</script>

<template>

  <!-- Local onde sera renderizado meu menu -->
  <Menu />

  <div class="container mt-3">

    <!-- Local onde sera renderizado minha view -->
    <RouterView />

  </div>

</template>