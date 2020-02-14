import axios from 'axios';
import {obterInformacoesJWT} from '../helpers/jwt';
import {eventHub} from '@/event';

const instance = axios.create({
  baseURL: process.env.VUE_APP_API_HOST,
});

const tratarErro = (error) => {
  let msgErro = 'Desculpe, houve um erro ao executar a operação';

  if (error.response && error.response.data.message) {
    if (error.response.status === 401) {

      msgErro = 'Seu acesso expirou!';
      eventHub.$emit('eventoErro', msgErro);

      window.location.href = '/login';
    }

    msgErro = error.response.data.message;
  }

  /*
   * Event Bus - No arquivo app.vue há um tratamento para esse evento
   */
  eventHub.$emit('eventoErro', msgErro);
  return Promise.reject(error);
};

const isEmpty = string => (!string || string.length === 0);

// request
instance.interceptors.request.use((config) => {
  const userToken = localStorage.getItem('user_token');
  const conf = config;

  const tokenValida = !isEmpty(obterInformacoesJWT(userToken));

  if (tokenValida) {
    conf.headers.Authorization = `Bearer ${userToken}`;
  }
  return conf;
}, error => Promise.reject(error));

// response
instance.interceptors.response.use(response => response, (error) => {
  tratarErro(error);
  return Promise.reject(error);
});

export const getRequest = (path, params = '') => instance.get(path, params);

export const postRequest = (path, payload) => instance.post(path, payload);

export const putRequest = (path, id, payload) => instance.put(`${path}/${id}`, payload);

export const deleteRequest = (path, id, payload = {}) => instance.delete(`${path}/${id}`, {data: payload});

export const obterBinarioArquivo = (coArquivo, config = {responseType: 'blob'}) => instance.get(`/arquivo/${coArquivo}`, config);

export const buildData = function (obj, form, namespace) {
  const fd = form || new FormData();
  let formKey;

  for (const property in obj) {
    if (obj.hasOwnProperty(property)) {
      if (namespace) {
        formKey = `${namespace}[${property}]`;
      } else {
        formKey = property;
      }

      // if the property is an object, but not a File,
      // use recursivity.
      if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
        buildData(obj[property], fd, property);
      } else {
        // if it's a string or a File object
        fd.append(formKey, obj[property]);
      }
    }
  }

  return fd;
};

export const clickLink = (response, noArquivo) => {
  const blob = response.data;
  const url = window.URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.setAttribute('download', noArquivo);
  document.body.appendChild(link);
  link.click();
}
