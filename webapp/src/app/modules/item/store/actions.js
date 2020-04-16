import * as types from './types';
import { requisicaoAutorizada } from '../../account/_helpers/requisicao-autorizada';

const BASE_URL = 'http://localhost/v1';

export const getItensInstituicao = ({ commit }, instituicaoID) => {
  requisicaoAutorizada
    .get(`${BASE_URL}/instituicoes/${instituicaoID}/itens`)
    .then((resp) => {
      commit(types.GET_ITENS_INSTITUICAO, resp.data.data);
    });
};

export const storeItem = ({ commit, dispatch }, item) => {
  requisicaoAutorizada
    .post(`${BASE_URL}/itens`, item)
    .then(() => {
      commit(types.STORE_ITEM, item);
      dispatch('alert/success', 'Item salvo com sucesso!', { root: true });
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao salvar o item.', { root: true });
    });
};

export const updateItem = ({ commit, dispatch }, item) => {
  requisicaoAutorizada
    .patch(`${BASE_URL}/itens/${item.id}`, item)
    .then(() => {
      commit(types.UPDATE_ITEM, item);
      dispatch('alert/success', 'Item atualizado com sucesso!', { root: true });
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao atualizar o item.', { root: true });
    });
};

export const deleteItem = ({ commit, dispatch }, item) => {
  requisicaoAutorizada
    .delete(`${BASE_URL}/itens/${item.id}`)
    .then(() => {
      commit(types.DELETE_ITEM, item);
      dispatch('alert/success', 'Item deletado com sucesso!', { root: true });
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao deletar o item.', { root: true });
    });
};
