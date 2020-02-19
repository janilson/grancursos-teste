import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://localhost:8022/api',
});

export const getRequest = (path, params = '') => instance.get(path, params);

