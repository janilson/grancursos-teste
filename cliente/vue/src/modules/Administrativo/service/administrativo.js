import * as service from '../../shared/service/base/index';

export const listar = (params) => service.getRequest('/adesao', {params: params});
export const adesaoMunicipioDownload = (params, headers) => {
  const config = {
    params: params,
    headers: headers,
    responseType: 'blob'
  };

  return service.getRequest(`/adesao`, config);
};

export const listarRepresentantes = (params) => service.getRequest('/servidor', {params: params});
export const representantesMunicipioDownload = (params, headers) => {
  const config = {
    params: params,
    headers: headers,
    responseType: 'blob'
  };

  return service.getRequest(`/servidor`, config);
};


export const listarInscritos = (params) => service.getRequest('/adesao?com_inscricao=true', {params: params});
export const inscritosMunicipioDownload = (params, headers) => {
  const config = {
    params: params,
    headers: headers,
    responseType: 'blob'
  };

  return service.getRequest(`/adesao?com_inscricao=true`, config);
};

export const listarUf = () => service.getRequest('/uf');
export const listarMunicipio = (co_uf) => service.getRequest(`/uf/${co_uf}/municipio`);
