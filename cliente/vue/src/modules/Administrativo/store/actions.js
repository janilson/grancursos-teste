import * as administrativoService from '../service/administrativo';
import * as classificadosService from '../service/classificados';

import * as types from "../../Administrativo/store/types";
import * as sharedService from "../../shared/service/shared";

import {clickLink} from "../../shared/service/base/index";
import * as grupoService from "../../Inscricao/service/grupo";

export const listarAdesoes = async ({commit, dispatch}, params) => administrativoService
  .listar(params)
  .then((response) => {
    if (!response.data.data.length) {
      dispatch(
        'app/setMensagemErro',
        'Não foi localizado município para condição informada!', {root: true},
      );
    }

    commit(types.FILTER_ADESOES_MUNICIPIO, params);
    commit(types.FETCH_ALL_ADESOES_MUNICIPIO, response.data);
    return response.data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarAdesoes', 10);
  });

export const limparAdesoes = ({commit}) => commit(types.EMPTY_ADESOES_MUNICIPIO);

export const limparFiltro = ({commit}) => commit(types.RESET_FILTER_ADESOES_MUNICIPIO);

export const downloadAdesao = async ({commit, dispatch}, {params, acceptType, type}) => sharedService
  .download(params, {'Accept': `${acceptType}`}, `/adesao`)
  .then((response) => {
    const noArquivo = `adesoes.${type}`;
    clickLink(response, noArquivo);
  });

export const listarClassificados = async ({commit, dispatch}, params) => classificadosService
  .listarClassificados(params)
  .then(response => {
    if (!response.data.data.length) {
      dispatch(
        'app/setMensagemErro',
        'Não foi localizado classificado para condição informada!', {root: true},
      );
    }

    commit(types.FILTER_CLASSIFICADOS, params);
    commit(types.FETCH_ALL_CLASSIFICADOS, response.data);

    return response.data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarClassificados', 10);
  });

export const limparClassificados = ({commit}) => commit(types.EMPTY_CLASSIFICADOS);
export const limparFiltroClassificados = ({commit}) => commit(types.RESET_FILTER_CLASSIFICADOS);

/** Representantes*/

export const listarRepresentantes = async ({commit, dispatch}, params) => administrativoService
  .listarRepresentantes(params)
  .then((response) => {
    if (!response.data.data.length) {
      dispatch(
        'app/setMensagemErro',
        'Não foi localizado representante para condição informada!', {root: true},
      );
    }

    commit(types.FILTER_REPRESENTANTES_MUNICIPIO, params);
    commit(types.FETCH_ALL_REPRESENTANTES_MUNICIPIO, response.data);
    return response.data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarRepresentantes', 10);
  });

export const limparRepresentantes = ({commit}) => commit(types.EMPTY_REPRESENTANTES_MUNICIPIO);

export const limparFiltroRepresentantes = ({commit}) => commit(types.RESET_FILTER_REPRESENTANTES_MUNICIPIO);

export const downloadRepresentantes = async ({commit, dispatch}, {params, acceptType, type}) => sharedService
  .download(params, {'Accept': `${acceptType}`}, `/servidor`)
  .then((response) => {
    const noArquivo = `representantes.${type}`;
    clickLink(response, noArquivo);
  });

/** Inscritos*/

export const listarInscritos = async ({commit, dispatch}, params) => administrativoService
  .listarInscritos(params)
  .then((response) => {
    if (!response.data.data.length) {
      dispatch(
        'app/setMensagemErro',
        'Não foi localizado município para condição informada!', {root: true},
      );
    }

    commit(types.FILTER_INSCRITOS_MUNICIPIO, params);
    commit(types.FETCH_ALL_INSCRITOS_MUNICIPIO, response.data);

    return response.data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarInscritos', 10);
  });

export const limparInscritos = ({commit}) => commit(types.EMPTY_INSCRITOS_MUNICIPIO);

export const limparFiltroInscritos = ({commit}) => commit(types.RESET_FILTER_INSCRITOS_MUNICIPIO);

export const downloadInscritos = async ({commit, dispatch}, {params, acceptType, type}) => sharedService
  .download(params, {'Accept': `${acceptType}`}, `/adesao?com_inscricao=true`)
  .then((response) => {
    const noArquivo = `inscritos.${type}`;
    clickLink(response, noArquivo);
  });


/** Coorporativo */
export const listarUf = async ({commit, dispatch}) => administrativoService
  .listarUf()
  .then((response) => {

    return response.data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarUf', 10);
  });

export const listarMunicipio = async ({commit, dispatch}, co_uf) => administrativoService
  .listarMunicipio(co_uf)
  .then((response) => {
    return response.data;
  }).catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'listarMunicipio', 10);
  });

export const aprovarRelatorio = async ({commit, dispatch}, coAdesao) => classificadosService
  .aprovarRelatorio(coAdesao)
  .then((response) => {
      return response.data;
    }
  )
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'aprovarRelatorio', 10);
  });

export const downloadClassificados = async ({commit, dispatch}, {params, acceptType, type}) => sharedService
  .download(params, {'Accept': `${acceptType}`}, `/classificacao`)
  .then((response) => {
    const noArquivo = `'Lista 45 classificados.${type}`;
    clickLink(response, noArquivo);
  });

export const atualizarAdesao = async ({commit, dispatch}, adesao) => classificadosService
  .atualizarAdesao(adesao)
  .then(response => {
    return response.data;
  })
  .catch((error) => {
    dispatch(
      'app/setMensagemErro',
      error.response.data.message, {root: true},
    );
    throw new TypeError(error.response.data.message, 'atualizarAdesao', 10);
  });
