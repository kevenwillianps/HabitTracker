// importação de dependências
import { defineStore } from 'pinia';
import { ref } from 'vue';
import axios from 'axios';

// Define o nome da função a ser exportada
export const useUsersStore = defineStore('usersStore', () => {

    // Define as variaveis que seram retornadas
    const users = ref([]);

    // Cria a função que ira realizar a busca dos usuários
    async function fetchUsers(path){

        try {

            // Realiza a requisição para a API
            const response = await axios.post(`http://localhost/habitTracker/api/router.php`, {
                path : path
            });

            //Guarda os dados da requisição
            users.value = response.data;

        }catch (error) {

            //Define a mesnagem de erro
            console.error('Erro ao buscar usuários:', error);

        }

    }

    // Retorna as variaveis e funções
    return {users, fetchUsers};

});