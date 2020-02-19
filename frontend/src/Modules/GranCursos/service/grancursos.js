import * as service from '../../shared/service/base/index';

export const listarAssuntos = async (params) => service.getRequest('/assunto', params);
export const listarBancas = async (params) => service.getRequest('/banca', params);
export const listarOrgaos = async (params) => service.getRequest('/orgao', params);

