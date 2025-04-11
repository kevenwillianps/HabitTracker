// src/services/api.js
import axios from 'axios'

// Configuração do Axios para a API
export async function api(path = '') {
    try {
        const response = await axios.post(
            'http://localhost/habitTracker/api/router.php',
            { path },
            {
                headers: {
                    'Content-Type': 'application/json',
                },
                timeout: 10000,
                responseType: 'json',
            }
        )

        return response.data
    } catch (error) {
        console.error(error)
        return { erro: true, mensagem: 'Erro na requisição' }
    }
}
