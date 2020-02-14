import * as service from '../../shared/service/base/index';

export const recuperarGrupos = coAdesao => service.getRequest(`/grupo?co_adesao=${coAdesao}`);
export const atualizarDadosGrupo = async (grupo) => service.putRequest(`/adesao/${grupo.co_adesao}/grupo`, grupo.co_grupo, grupo.payload);
