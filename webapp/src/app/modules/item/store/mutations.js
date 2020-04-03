import * as types from './types';

export const mutations = {
  [types.GET_ITENS_INSTITUICAO](state, payload) {
    state.itens = payload;
  },
  [types.STORE_ITEM](state, item) {
    state.itens.push(item);
  },
  [types.DELETE_ITEM](state, item) {
    const index = state.itens.indexOf(item);
    state.itens.splice(index, 1);
  },
  [types.UPDATE_ITEM](state, item) {
    const index = state.itens.findIndex((itens) => itens.id === item.id);
    Object.assign(state.itens[index], item);
  }
};
