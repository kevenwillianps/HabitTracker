// src/utils/request.js
import axios from 'axios'

// Base URL vinda do .env
axios.defaults.baseURL = import.meta.env.VITE_API_URL

export async function apiRequest(path, data = {}, method = 'post') {
  try {
    const config = {
      method,
      url: '', // o endpoint é sempre o mesmo, o path vai nos dados
      data: {
        path,
        ...data
      }
    }

    const response = await axios.request(config)
    return response.data
  } catch (error) {
    console.error('Erro na requisição:', error)
    throw error
  }
}
