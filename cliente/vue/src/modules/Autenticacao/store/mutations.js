import * as types from './types';

export const state = {
  usuarios: [],
};

export const mutations = {
  [types.DELETE_USUARIO](state, id) {
    const index = state.usuarios.findIndex(
      item => parseInt(item.co_usuario, 10) === parseInt(id, 10),
    );
    state.usuarios.splice(index, 1);
  },
};
