import * as service from '../../shared/service/base/index';

export const getBloquieo =  (co_adesao) => service.getRequest(`/bloqueio/${co_adesao}`);
export const postBloquieo = (payload) => service.postRequest(`/bloqueio`, payload);
export const putBloquieo = () => service.putRequest(`/bloqueio/${co_adesao}`);
export const deleteBloquieo = () => service.putRequest(`/bloqueio/${co_adesao}`);
