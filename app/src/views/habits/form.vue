<template>
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div class="fs-3 fw-medium">
                Registro de novo Hábito
            </div>
            <RouterLink to="/habits" class="btn btn-secondary btn-sm">
                <img :src="listIcon" width="20px"> Lista
            </RouterLink>
        </div>
        <hr>
        <form id="UsersForm" @submit.prevent="sendForm">
            <div class="row g-2">
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="name" v-model="formData.name" placeholder="Nome">
                        <label for="name">Nome</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="description" v-model="formData.description"
                            placeholder="Descrição">
                        <label for="description">Descrição</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="url" v-model="formData.url" placeholder="Url">
                        <label for="url">Url</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="starts_in" v-model="formData.starts_in"
                            placeholder="Início">
                        <label for="starts_in">Inicio</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="ends_in" v-model="formData.ends_in"
                            placeholder="Fim">
                        <label for="ends_in">Fim</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select" id="situation_id" aria-label="situations"
                            v-model="formData.situation_id">
                            <option v-for="(situation, indice) in situations" :value="situation.situation_id"
                                :key="indice">
                                {{ situation.name }}
                            </option>
                        </select>
                        <label for="situation_id">Situação</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select" id="category_id" aria-label="category_id"
                            v-model="formData.category_id">
                            <option v-for="(category, indice) in categories" :value="category.category_id"
                                :key="indice">
                                {{ category.name }}
                            </option>
                        </select>
                        <label for="category_id">Categoria</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select" id="type_id" aria-label="type_id" v-model="formData.type_id">
                            <option v-for="(type, indice) in types" :value="type.type_id" :key="indice">
                                {{ type.name }}
                            </option>
                        </select>
                        <label for="type_id">Tipos</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating">
                        <select class="form-select" id="group_id" aria-label="group_id" v-model="formData.group_id">
                            <option v-for="(group, indice) in groups" :value="group.group_id" :key="indice">
                                {{ group.name }}
                            </option>
                        </select>
                        <label for="group_id">Grupos</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>

// Importação de compoentes e bibliotecas
import { ref, onMounted, reactive } from 'vue';
import { useRoute } from 'vue-router';
import { apiRequest } from '@/utils/api'

import listIcon from '@/assets/images/list.png';

const route = useRoute();

// Defino o objeto de dados do formulário
const formData = reactive({
    category_id: 0,
    description: '',
    ends_in: '',
    group_id: 0,
    habit_id: 0,
    name: '',
    situation_id: 0,
    starts_in: '',
    type_id: 0,
    url: '',
    user_id: 0

});

// Define a variavel reativa para armazenar os dados
const categories = ref([]);
const situations = ref([]);
const types = ref([]);
const groups = ref([]);

// Função executada quando o componente é montado
onMounted(async () => {

    // Busca as categorias
    categories.value = await apiRequest({ 'request': { 'path': 'action/categories/categories_list', 'method': 'post' } });

    // Busca as situações
    situations.value = await apiRequest({ 'request': { 'path': 'action/situations/situations_list', 'method': 'post' } });

    // Busca os tipos
    types.value = await apiRequest({ 'request': { 'path': 'action/types/types_list', 'method': 'post' } });

    // Busca os grupos
    groups.value = await apiRequest({ 'request': { 'path': 'action/groups/groups_list', 'method': 'post' } });

    // Verifica se deve buscar o registro
    if (route.params.id > 0) {

        // Busca o registro
        const response = await apiRequest({
            'request': { 'path': 'action/habits/habits_get', 'method': 'post', 'data': { 'habit_id': route.params.id } }
        });

        // Guarda os dados do objeto no formulário sem perder a reatividade
        Object.assign(formData, response.data)

    }

});

async function sendForm() {

    await apiRequest({
        'request': { 'path': 'action/habits/habits_save', 'method': 'post', 'data': formData },
        'toast': { 'class': 'bg-success', 'message': 'Situação cadastrado com sucesso!' }
    })
        .then((response) => {

            // Exibe uma mensagem de sucesso caso o envio seja bem sucedido
            console.log(response);

        })

        .catch((error) => {

            // Exibe um erro caso o envio falhe
            console.error(error);
        });

}

</script>