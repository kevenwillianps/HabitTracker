<template>
  <div>
    <h1>Usuários</h1>

    {{ data }}

  </div>
</template>

<script setup>
  import axios from 'axios';
  import { ref } from 'vue';

  const data = ref();

  axios.post('', {
    path : 'action/users/users_list',
  })

  .then((response) => {
    data.value = response.data;
  })

</script>
