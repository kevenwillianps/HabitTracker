<script setup>
import { RouterLink, RouterView } from 'vue-router'
import Menu from '@/layout/Menu.vue'; // quando for export default, usarm sem {}
import Toast from '@/components/general/toast.vue';

</script>

<template>

  <div class="container my-3">

    <div class="row">

      <div class="col-md-8 mx-auto">

        <!-- Local onde sera renderizado meu menu -->
        <Menu />

        <div class="card">

          <!-- <div class="card-header bg-white border-bottom-0"> -->

          <!-- </div> -->

          <!-- Local onde sera renderizado minha view -->
          <RouterView />

        </div>

      </div>

    </div>

  </div>

  <Toast />

</template>

<style type="text/scss">
body {
  background-color: #f9f9f9;
}
</style>