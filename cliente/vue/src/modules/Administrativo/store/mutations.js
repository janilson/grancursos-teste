import * as types from './types';

export const mutations = {
  [types.FETCH_ALL_ADESOES_MUNICIPIO](state, adesoes) {
    state.adesoesMunicipio = adesoes;
  },
  [types.EMPTY_ADESOES_MUNICIPIO](state) {
    state.adesoesMunicipio = [];
  },
  [types.FILTER_ADESOES_MUNICIPIO](state, params) {
    state.filtroAdesoesMunicipio = params;
  },
  [types.RESET_FILTER_ADESOES_MUNICIPIO](state) {
    state.filtroAdesoesMunicipio = {};
  },

  [types.FETCH_ALL_REPRESENTANTES_MUNICIPIO](state, representantes) {
    state.representantesMunicipio = representantes;
  },
  [types.EMPTY_REPRESENTANTES_MUNICIPIO](state) {
    state.representantesMunicipio = [];
  },
  [types.FILTER_REPRESENTANTES_MUNICIPIO](state, params) {
    state.filtroRepresentantesMunicipio = params;
  },
  [types.RESET_FILTER_REPRESENTANTES_MUNICIPIO](state) {
    state.filtroRepresentantesMunicipio = {};
  },

  [types.FETCH_ALL_INSCRITOS_MUNICIPIO](state, inscritos) {
    state.inscritosMunicipio = inscritos;
  },
  [types.EMPTY_INSCRITOS_MUNICIPIO](state) {
    state.inscritosMunicipio = [];
  },
  [types.FILTER_INSCRITOS_MUNICIPIO](state, params) {
    state.filtroInscritosMunicipio = params;
  },
  [types.RESET_FILTER_INSCRITOS_MUNICIPIO](state) {
    state.filtroInscritosMunicipio = {};
  },

  [types.FETCH_ALL_CLASSIFICADOS](state, classificados) {
    state.classificados = classificados;
  },
  [types.EMPTY_CLASSIFICADOS](state) {
    state.classificados = [];
  },
  [types.FILTER_CLASSIFICADOS](state, params) {
    state.filtroClassificados = params;
  },
  [types.RESET_FILTER_CLASSIFICADOS](state) {
    state.filtroClassificados = {};
  },
};
