<template>
    <div class="card-body">
        <h1>
            Categorias/Formulário
        </h1>
        <div class="card">
            <div class="card-body">
                <form id="UsersForm" @submit.prevent="sendForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="name" class="form-control" id="name" v-model="formData.name"
                                    placeholder="Nome">
                                <label for="name">Nome</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>

// Importação de compoentes e bibliotecas
import { reactive } from 'vue';
import { apiRequest } from '@/utils/api'

// Defino o objeto de dados do formulário
const formData = reactive({
    name: '',
    description: ''
});

async function sendForm() {

    await apiRequest({
        'request': { 'path': 'action/categories/categories_save', 'method': 'post', 'data': formData },
        'toast': { 'class': 'bg-success', 'message': 'Situação cadastrado com sucesso!' }
    })
        .then((response) => {

            // Limpa os campos do formulário após o envio
            formData.name = '';
            formData.description = '';
        })

        .catch((error) => {

            // Exibe um erro caso o envio falhe
            console.error(error);
        });

}

</script>