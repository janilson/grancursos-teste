import * as granCursosService from '../service/grancursos';

// eslint-disable-next-line no-unused-vars
export const listarAssuntos = async ({commit, dispatch}, params) => granCursosService
    .listarAssuntos(params)
    .then((response) => {
        return response.data.data;
    }).catch((error) => {
        throw new TypeError(error, 'listarAssuntos', 10);
    });

// eslint-disable-next-line no-unused-vars
export const listarBancas = async ({commit, dispatch}, params) => granCursosService
    .listarBancas(params)
    .then((response) => {
        return response.data.data;
    }).catch((error) => {
        throw new TypeError(error, 'listarBancas', 10);
    });

// eslint-disable-next-line no-unused-vars
export const listarOrgaos = async ({commit, dispatch}, params) => granCursosService
    .listarOrgaos(params)
    .then((response) => {
        return response.data.data;
    }).catch((error) => {
        throw new TypeError(error, 'listarOrgaos', 10);
    });
