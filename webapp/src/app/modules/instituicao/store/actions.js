import axios from 'axios';
import * as types from './types';
import { requisicaoAutorizada } from '../../account/_helpers/requisicao-autorizada';

const BASE_URL = 'http://localhost/v1';

export const obterInstituicoes = ({ dispatch, commit }) => {
  requisicaoAutorizada
    .get(`${BASE_URL}/instituicoes`)
    .then((response) => {
      const { data } = response;
      commit(types.OBTER_INSTITUICOES, data.data);
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao obter instituições.', { root: true });
    });
};

export const removerInstituicao = ({ dispatch, commit }, instituicaoId) => {
  requisicaoAutorizada
    .delete(`${BASE_URL}/instituicoes/${instituicaoId}`)
    .then(() => {
      commit(types.DELETE_INSTITUICAO, instituicaoId);
      dispatch('alert/success', 'Instituição excluido com sucesso!', {
        root: true
      });
    })
    .catch(() => {
      dispatch('alert/error', 'Desculpe, Não encontramos a Instituição', {
        root: true
      });
    });
};

export const cadastrarInstituicao = ({ dispatch, commit }, instituicao) =>
  axios
    .post(`${BASE_URL}/instituicoes`, instituicao)
    .then((response) => {
      const { data } = response;
      commit(types.ACRESCENTAR_INSTITUICAO, data.data);
      dispatch('alert/success', 'Instituição cadastado com sucesso!', {
        root: true
      });
    })
    .catch(() => {
      dispatch('alert/error', 'Falhar ao cadastrar Instituicao', {
        root: true
      });
    });
export const setImage = ({ commit }, instituicao) => {
  commit(types.ATUALIZAR_INSTITUICAO, instituicao);
};

export const atualizarInstituicao = ({ dispatch, commit }, instituicao) =>
  requisicaoAutorizada
    .patch(`${BASE_URL}/instituicoes/${instituicao.id}`, instituicao)
    .then(() => {
      commit(types.ATUALIZAR_INSTITUICAO, instituicao);
      dispatch('alert/success', 'Instituicao atualizado com sucesso!', {
        root: true
      });
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao atualizar insituição.', { root: true });
    });

export const setDialog = ({ commit }, payload) => {
  commit(types.ESTADO_DIALOG, payload);
};

export const obterInstiUser = ({ commit, dispatch }, userId) => {
  requisicaoAutorizada
    .get(`${BASE_URL}/user/${userId}/instituicoes/`)
    .then((response) => {
      const { data } = response;
      commit(types.OBTER_INSTITUICOES, data.data);
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao obter instituições.', { root: true });
    });
};

export const insitituicaoEditar = ({ commit }, payload) => {
  commit(types.INSTITUICAO_EDITAR, payload);
};

export const buscartInstituicao = ({ commit, dispatch }, instituicaoId) => {
  axios
    .get(`${BASE_URL}/instituicoes/${instituicaoId}`)
    .then((resp) => {
      commit(types.INSTITUICAO_ENCONTRADA, resp.data.data[0]);
    })
    .catch((error) => {
      dispatch('alert/error', error, { root: true });
    });
};
