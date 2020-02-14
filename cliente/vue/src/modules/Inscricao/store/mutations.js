import * as types from './types';
import Vue from 'vue';

export const mutations = {
  [types.DELETE_USUARIO](state, id) {
    const index = state.usuarios.findIndex(
      item => parseInt(item.co_usuario, 10) === parseInt(id, 10),
    );
    state.usuarios.splice(index, 1);
  },
  [types.FETCH_ALL_ADESOES](state, adesoes) {
    state.adesoes = adesoes.map(adesao => {
      return {
        label: `${adesao.no_municipio} - ${adesao.no_uf}`,
        value: adesao.co_adesao
      };
    });
  },
  [types.FETCH_GRUPOS](state, grupos) {
    grupos.data.forEach(grupo => {
      let perguntas = [];
      let ultimaPergunta = '';

      grupo.itens.forEach(item => {
        switch (true) {
          case !item.pergunta:
            perguntas.push({
              co_formulario_item_inscricao: item.co_formulario_item_inscricao,
              co_formulario_resposta: item.co_formulario_resposta,
              label: item.ds_formulario_item_inscricao,
              value: item.co_formulario_item_inscricao,
              st_resposta: item.st_resposta,
              nu_pontuacao: item.nu_pontuacao,
            });
            break;

          case ultimaPergunta !== item.pergunta.ds_pergunta:
            perguntas.push({
              label: item.pergunta.ds_pergunta
            });
            perguntas.push(
              {
                co_formulario_item_inscricao: item.co_formulario_item_inscricao,
                co_formulario_resposta: item.co_formulario_resposta,
                label: item.ds_formulario_item_inscricao,
                value: item.co_formulario_item_inscricao,
                st_resposta: item.st_resposta,
                nu_pontuacao: item.nu_pontuacao,

              }
            );
            ultimaPergunta = item.pergunta.ds_pergunta;
            break;

          default:
            perguntas.push({
              co_formulario_item_inscricao: item.co_formulario_item_inscricao,
              co_formulario_resposta: item.co_formulario_resposta,
              label: item.ds_formulario_item_inscricao,
              value: item.co_formulario_item_inscricao,
              st_resposta: item.st_resposta,
              nu_pontuacao: item.nu_pontuacao
            });
            ultimaPergunta = item.pergunta.ds_pergunta;
            break;
        }
      });
      grupos = {
        nu_pontuacao_total: grupo.nu_pontuacao_total,
        ds_grupo: grupo.ds_grupo,
        co_grupo: grupo.co_grupo,
        perguntas: perguntas
      };

      state.grupos[grupo.co_grupo] = grupos;
    })
  },
  [types.ALTERAR_GRUPO_RESPOSTA](state, grupos) {
    state.grupos[grupos.coGrupo].perguntas.forEach(grupo => {
      if (grupos.coFormularioItemInscricao === grupo.co_formulario_item_inscricao) {
        grupo.st_resposta = grupos.stResposta;
      }

      if (grupos.coGrupo === 5) {
        if (grupos.coFormularioItemInscricao !== grupo.co_formulario_item_inscricao) {
          grupo.st_resposta = false;
        }
      }
    });
  },
  [types.FETCH_ALL_INSCRICAO](state, inscricoes) {
    state.inscricoes = inscricoes;
  },
  [types.FETCH_INSCRICAO](state, inscricao) {
    state.inscricoes.push(inscricao);
  },
  [types.FETCH_ALL_HISTORICO](state, historicos) {
    state.historicos = historicos;
  },
  [types.EMPTY_HISTORICO](state) {
    state.historicos = [];
  },
  [types.FILTER_HISTORICO](state, params) {
    state.filtroHistoricos = params;
  },
  [types.LIMPAR_FILTRO_DATA_HISTORICO](state) {
    delete state.filtroHistoricos.dt_resposta;
  },
  [types.RESET_FILTER_HISTORICO](state) {
    state.filtroHistoricos = {};
  },
  [types.FETCH_ADESOES](state, adesoes) {
    state.todasAdesoes = adesoes.map(adesao => {
      return {
        label: `${adesao.no_municipio} - ${adesao.no_uf}`,
        value: adesao.co_adesao
      };
    });
  },
};
