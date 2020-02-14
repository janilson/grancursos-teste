import * as inscricaoService from '../service/inscricao';
import * as grupoService from '../service/grupo';
import * as types from './types';
import * as bloqueioService from "../service/bloqueio";
import * as sharedService from "../../shared/service/shared";
import {clickLink} from "../../shared/service/base/index";

/** Inscrição */

export const listarInscricao = async ({commit, dispatch}, usuario) => inscricaoService
  .listarInscricoes(usuario)
  .then((response) => {
    commit(types.FETCH_ALL_INSCRICAO, response.data.data);
    return response.data.data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarInscricao', 10);
  });


export const listarAdesoes = async ({commit, dispatch}, adesao) => inscricaoService
  .listarAdesoes(adesao)
  .then((response => {
    commit(types.FETCH_ALL_ADESOES, response.data.data);
    return response.data.data;
  }))
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarAdesoes', 10);
  });

export const recuperarGrupos = async ({commit, dispatch}, grupo) => grupoService
  .recuperarGrupos(grupo)
  .then((response => {
    commit(types.FETCH_GRUPOS, response.data);
    return response.data;
  }))
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'recuperarGrupos', 10);
  });

export const alterarRespostaGrupo = ({commit, dispatch}, grupo) => {
  commit(types.ALTERAR_GRUPO_RESPOSTA, grupo)
};

export const limparDataPesquisaHistorico = ({commit, dispatch}) => {
  commit(types.LIMPAR_FILTRO_DATA_HISTORICO)
};

export const iniciarInscricao = async ({commit, dispatch}, coAdesao) => inscricaoService
  .iniciarInscricao(coAdesao)
  .then((response) => {
      commit(types.FETCH_INSCRICAO, response.data.data);
      return response.data.data;
    }
  )
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'iniciarInscricao', 10);
  });

export const enviarPreRequisito = async ({commit, dispatch}, preRequisitos) => inscricaoService
  .enviarPreRequisito(preRequisitos)
  .then((response) => {
      return response.data.data;
    }
  )
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'enviarPreRequisito', 10);
  });

export const enviarInscricao = async ({commit, dispatch}, coAdesao) => inscricaoService
  .enviarInscricao(coAdesao)
  .then((response) => {
      return response.data;
    }
  )

  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'enviarInscricao', 10);
  });

export const atualizarDadosGrupo = async ({commit, dispatch}, grupo) => grupoService
  .atualizarDadosGrupo(grupo)
  .then(response => {
    return response.data;
  })
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'atualizarDadosGrupo', 10);
  });

export const downloadPdf = async ({commit, dispatch}, coAdesao) => inscricaoService
  .downloadInscricao(coAdesao)
  .then((response) => {
    const noArquivo = 'inscrição';
    const blob = response.data;
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', noArquivo);
    document.body.appendChild(link);
    link.click();
  });

export const downloadResumo = async ({commit, dispatch}, coAdesao) => inscricaoService
  .downloadResumo(coAdesao)
  .then((response) => {
    const noArquivo = 'resumo';
    const blob = response.data;
    const url = window.URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', noArquivo);
    document.body.appendChild(link);
    link.click();
  });

export const listarGrupos = async ({commit, dispatch}) => inscricaoService
  .listarGrupos()
  .then((response => {
    return response.data.data;
  }))
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarGrupos', 10);
  });

export const listarMinhasAdesoes = async ({commit, dispatch}, adesao) => inscricaoService
  .listarMinhasAdesoes(adesao)
  .then((response => {
    commit(types.FETCH_ALL_ADESOES, response.data.data);
    return response.data.data;
  }))
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarMinhasAdesoes', 10);
  });

export const listarHistorico = async ({commit, dispatch}, formulario) => inscricaoService
  .listarHistorico(formulario)
  .then((response) => {

    commit(types.FILTER_HISTORICO, formulario);
    commit(types.FETCH_ALL_HISTORICO, response.data);

    return response.data;

  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarHistorico', 10);
  });

export const limparHistorico = async ({commit, dispatch}) => commit(types.EMPTY_HISTORICO, []);

export const limparFiltroHistorico = ({commit}) => commit(types.RESET_FILTER_HISTORICO);

export const downloadHistorico = async ({commit, dispatch}, {params, acceptType, type}) => sharedService
  .download(params, {'Accept': `${acceptType}`}, `/adesao/${params.co_adesao}/historico`)
  .then((response) => {
    const noArquivo = `historicos.${type}`;
    clickLink(response, noArquivo);
  });

export const listarTodasAdesoes = async ({commit, dispatch}, adesao) => inscricaoService
  .listarTodasAdesoes(adesao)
  .then((response => {
    commit(types.FETCH_ADESOES, response.data.data);
    return response.data.data;
  }))
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarTodasAdesoes', 10);
  });

export const verificaBloqueio =  ({commit, dispatch}, co_adesao) =>  bloqueioService
  .getBloquieo(co_adesao)
  .then(async (response) => {
    return await response.data.data;
  })
;
