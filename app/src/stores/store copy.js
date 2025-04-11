// importação de dependências
import axios from 'axios';

const apiClient = axios.create({
    baseURL: 'http://localhost/habitTracker/api/router.php',
    timeout: 10000,
    headers: {
      'Content-Type': 'application/json',
    }
  })

  function handleError(error, mensagemPadrao) {
    console.error(error) // ou enviar para um logger
    // Você pode disparar um toast aqui também (se usar algum sistema global de mensagens)
    return { erro: true, mensagem: mensagemPadrao }
  }

  // Funções encapsuladas com tratamento de erro
export async function fetch(data) {
    try {
      const res = await apiClient.post(`http://localhost/habitTracker/api/router.php`, {
        path : data.path
      })
      return res.data
    } catch (error) {
      return handleError(error, 'Erro ao buscar usuários')
    }
  }