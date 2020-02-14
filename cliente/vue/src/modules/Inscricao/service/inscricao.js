import * as service from '../../shared/service/base/index';

export const listarInscricoes = () => service.getRequest('/adesao?usuario_logado=true&com_inscricao=true');
export const listarAdesoes = () => service.getRequest('/adesao?usuario_logado=true&sem_inscricao=true');
export const listarTodasAdesoes = () => service.getRequest('/adesao?all=true&nu_pontuacao=0');
export const iniciarInscricao = async (coAdesao) => service.postRequest(`/adesao/${coAdesao}/grupo`, {});
export const enviarInscricao = async (coAdesao) => service.postRequest(`/adesao/${coAdesao}/envio`);
export const downloadInscricao = async (coAdesao) => service.getRequest(`/inscricao/${coAdesao}/pdf`, { responseType: 'blob' });
export const downloadResumo = async (coAdesao) => service.getRequest(`/inscricao/${coAdesao}/resumo`, { responseType: 'blob' });
export const listarHistorico = formulario => service.getRequest(`/adesao/${formulario.co_adesao}/historico`, {params : formulario});
export const listarMinhasAdesoes = () => service.getRequest('/adesao?usuario_logado=true&com_inscricao=true');
export const listarGrupos = () => service.getRequest(`/grupo?not=1`, {});
export const enviarPreRequisito = async (preRequisitos) => service.postRequest(`/adesao/${preRequisitos.co_adesao}/grupo/${preRequisitos.co_grupo}/pre-requisito`, service.buildData(preRequisitos));


export const historicoDownload = (params, headers) => {
  const config = {
    params: params,
    headers: headers,
    responseType: 'blob'
  };

  return service.getRequest(`/adesao/${params.co_adesao}/historico`, config);
};
