<template>
  <div class="toast-container position-fixed bottom-0 start-50 translate-middle-x p-3">
    <TransitionGroup name="toast" tag="div">
      <div v-for="(toast, index) in toasts" :key="toast.id" :id="toast.id"
        :class="['toast align-items-center border-0 mt-1 show', toast.class]" role="alert" aria-live="assertive"
        aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">
            {{ toast.message }}
          </div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="remove(toast.id)"
            aria-label="Close" />
        </div>
      </div>
    </TransitionGroup>
  </div>
</template>

<script setup>

// Importaçã ode bibliotecas e dependências
import { reactive, onMounted, onUnmounted } from 'vue';
import emitter from '@/utils/toastBus';

// Define a variavel reativa
const toasts = reactive([]);

// Função responsável por exibir o toast
function show(data) {

  // Definição dinâmica de id
  data.id = Date.now();

  // Insere o toast na lista de toasts
  toasts.push(data);

  // Removendo o toast automaticamente após a duração
  setTimeout(() => {

    // Executa a função de remoção de acordo com o id
    remove(data.id);

  }, 4000);
}

/**
 * Função responsável por remover o toast da lista de toasts
 * @param id 
 */
function remove(id) {

  // Localiza o toast na lista de indices
  const index = toasts.findIndex((toast) => toast.id === id);

  // Verifica se o toast existe na lsita
  if (index !== -1) {

    // Remove o toast da lista
    toasts.splice(index, 1);

  }

}

/**
 * Operações executadas quando o componente é montado
 */
onMounted(() => {

  // Adicionar um listener para o evento 'toast' do emitter
  emitter.on('toast', (data) => {

    // Quando o evento 'toast' é emitido, chama a função show com os dados recebidos
    show(data);

  });

});

/**
 * Operações executadas quando o componente é desmontado
 * Remove o listener do evento 'toast' do emitter
 */
onUnmounted(() => {

  // Remoção do listener
  emitter.off('toast');

});

/**
 * Define a função show como exposta para que possa ser chamado por outros componentes
 */
defineExpose({

  // Nome da função
  show

});

</script>