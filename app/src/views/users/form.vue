<template>
    <div class="card-body">
        <h1>
            Usuários/Formulário
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
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" v-model="formData.email"
                                    placeholder="Email">
                                <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="password" v-model="formData.password"
                                    placeholder="****">
                                <label for="password">****</label>
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
import { reactive } from 'vue';
import { apiRequest } from '@/utils/api'

const formData = reactive({
    name: '',
    email: '',
    password: ''
});

async function sendForm() {

    await apiRequest({
        'request': { 'path': 'action/users/users_save', 'method': 'post', 'data': formData },
        'toast': { 'class': 'bg-success', 'message': 'Usuário cadastrado com sucesso!' }
    })
        .then((response) => {
            console.log(response);
            formData.name = '';
            formData.email = '';
            formData.password = '';
        })
        .catch((error) => {
            console.error(error);
        });

}

</script>