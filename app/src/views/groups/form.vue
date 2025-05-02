<template>
    <div class="card-body">
        <h1>
            Grupos/Formulário
        </h1>
        <div class="card">
            <div class="card-body">
                <form id="UsersForm" @submit.prevent="sendForm">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input type="preferences_icon" class="form-control" id="preferences_icon"
                                    v-model="formData.preferences" placeholder="Icone">
                                <label for="preferences_icon">Icone</label>
                            </div>
                        </div>
                        <div class="col-md-10">
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
import { onMounted, reactive } from 'vue';
import { useRoute } from 'vue-router';
import { apiRequest } from '@/utils/api';

const route = useRoute();

// Defino o objeto de dados do formulário
const formData = reactive({
    group_id: null,
    name: null,
    preferences: null
});

onMounted(async () => {

    // Verifica se existe id na rota para editar
    if (route.params.id > 0) {

        // Busca os dados do grupo para editar
        const response = await apiRequest({
            'request': { 'path': 'action/groups/groups_get', 'method': 'post', 'data': { 'group_id': route.params.id } }
        });

        // Sincroniza os dados do formulário com os dados retornados
        Object.assign(formData, response.data);

    }

});

async function sendForm() {

    await apiRequest({
        'request': { 'path': 'action/groups/groups_save', 'method': 'post', 'data': formData },
        'toast': { 'class': 'bg-success', 'message': 'Situação cadastrado com sucesso!' }
    })
        .then((response) => {

            // Limpa os campos do formulário após o envio
            console.log(response.data);
        })

        .catch((error) => {

            // Exibe um erro caso o envio falhe
            console.error(error);
        });

}

</script>