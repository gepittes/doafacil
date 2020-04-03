import * as types from './types';
import { requisicaoAutorizada } from '../../account/_helpers/requisicao-autorizada';

const URL = 'http://localhost/v1';

export const getItensInstituicao = ({ commit }, instituicaoID) => {
  requisicaoAutorizada
    .get(`${URL}/item/instituicao/${instituicaoID}`)
    .then((resp) => {
      commit(types.GET_ITENS_INSTITUICAO, resp.data.data);
    });
};

export const storeItem = ({ commit, dispatch }, item) => {
  requisicaoAutorizada
    .post(`${URL}/item`, item)
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
    .patch(`${URL}/item/${item.id}`, item)
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
    .delete(`${URL}/item/${item.id}`)
    .then(() => {
      commit(types.DELETE_ITEM, item);
      dispatch('alert/success', 'Item deletado com sucesso!', { root: true });
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao deletar o item.', { root: true });
    });
};
