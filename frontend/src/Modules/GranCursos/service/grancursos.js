import * as service from '../../shared/service/base/index';

export const listarAssuntos = (params) => service.getRequest('/assunto', {params : params});
export const listarBancas = async (params) => service.getRequest('/banca', params);
export const listarOrgaos = async (params) => service.getRequest('/orgao', params);

