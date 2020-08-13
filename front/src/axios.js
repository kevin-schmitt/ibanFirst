"use strict";

import axios from "axios";

const API_URL = process.env.API_URL || 'http://127.0.0.1:9010/api'

let config = {
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json'
  }
};

const instance = axios.create(config);



axios.interceptors.request.use(
  (config) => {
    let token = localStorage.getItem('token')

    if (token) {
      config.headers['Authorization'] = `Bearer ${ token }`
    }

    return config
  },

  (error) => {
    return Promise.reject(error)
  }
)

export default instance;
