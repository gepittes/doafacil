import * as types from './types';

export const mutations = {
  [types.GET_ITENS_INSTITUICAO](state, payload) {
    state.itens = payload;
  }
};
