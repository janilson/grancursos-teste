import * as granCursosService from '../service/grancursos';

export const listarAssuntos = async (params) => granCursosService
    .listarAssuntos(params)
    .then((response) => {
        return response.data.data;
    }).catch((error) => {
        throw new TypeError(error, 'listarAssuntos', 10);
    });

export const listarBancas = async (params) => granCursosService
    .listarBancas(params)
    .then((response) => {
        return response.data.data;
    }).catch((error) => {
        throw new TypeError(error, 'listarBancas', 10);
    });

export const listarOrgaos = async (params) => granCursosService
    .listarOrgaos(params)
    .then((response) => {
        return response.data.data;
    }).catch((error) => {
        throw new TypeError(error, 'listarOrgaos', 10);
    });
