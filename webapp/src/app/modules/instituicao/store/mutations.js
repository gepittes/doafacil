import * as types from "./types";

export const mutations = {
  [types.OBTER_INSTITUICOES](state, instituicao) {
    state.instituicao = instituicao;
  },
  [types.ACRESCENTAR_INSTITUICAO](state, instituicao) {
    state.instituicao.push(instituicao);
  },
  [types.DELETE_INSTITUICAO](state, instituicaoID) {
    const index = state.instituicao.findIndex(
      instituicao => instituicao.id === instituicaoID
    );
    state.instituicao.splice(index, 1);
  },
  [types.ATUALIZAR_INSTITUICAO](state, instituicaoEditada) {
    const index = state.instituicao.findIndex(
      instituicao => instituicao.id === instituicaoEditada.id
    );
    Object.assign(state.instituicao[index], instituicaoEditada);
  },
  [types.ESTADO_DIALOG](state, payload) {
    state.dialog = payload;
  },
  [types.INSTITUICAO_EDITAR](state, payload) {
    state.instituicaoEditar = payload;
  },
  [types.INSTITUICAO_ENCONTRADA](state, payload) {
    state.instituicaoEncontrada = payload;
  }
};
