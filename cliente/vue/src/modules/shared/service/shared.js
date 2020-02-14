import * as service from './base/index';
/* eslint-disable import/prefer-default-export */

// `${path}/${id}`
export const downloadArquivo = coArquivo => service.downloadArquivo(coArquivo);
export const obterBinarioArquivo = coArquivo => service.obterBinarioArquivo(coArquivo);
export const download = (params, headers, path) => {
  const config = {
    params: params,
    headers: headers,
    responseType: 'blob'
  };

  return service.getRequest(`${path}`, config);
};
