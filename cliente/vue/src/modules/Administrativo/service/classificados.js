import * as service from '../../shared/service/base/index';

export const listarClassificados = (params) => service.getRequest('/classificacao', {params: params});
export const atualizarAdesao = async (adesao) => service.putRequest(`/adesao`, adesao.co_adesao, adesao);

export const classificadosDownload = (params, headers) => {
  const config = {
    params: params,
    headers: headers,
    responseType: 'blob'
  };

  return service.getRequest(`/classificacao `, config);
};


export const aprovarRelatorio = () => service.postRequest(`/classificacao `);

