// Importação de bibliotecas e dependências
import axios from 'axios';
import emitter from '@/utils/toastBus';

// Base URL vinda do .env
axios.defaults.baseURL = import.meta.env.VITE_API_URL

// Configuração do cabeçalho da requisição
export async function apiRequest(data) {

  try {

    // Configuração da requisição
    const config = {

      method: data.request.method, // método da requisição (GET, POST, etc.)
      url: 'router.php', // o endpoint é sempre o mesmo, o path vai nos dados
      data: {
        path: data.request.path,
        ...data.request.data
      }

    }

    // Guardo o resultado da requisição na variável response
    const response = await axios.request(config)

    // Verifico se devo exibir o toast
    if (data.toast) {

      // Emite um sinal de ativação para o toast
      emitter.emit('toast', data.toast);

    }

    // Retorno o resultado da requisição
    return response.data

  } catch (error) {

    // Em caso de erro, imprimo no console
    console.error('Erro na requisição:', error)

    // Retorno o erro para o componente que chamou a função
    throw error

  }

}
