import axios from 'axios';
import * as types from './types';
import { requisicaoAutorizada } from '../../account/_helpers/requisicao-autorizada';

const BASE_URL = 'http://localhost/v1';

export const setPontoEditar = ({ commit }, pontoEditar) => {
  commit(types.SET_PONTO_EDITAR, pontoEditar);
};

export const setImage = ({ commit }, ponto) => {
  commit(types.ATUALIZAR_PONTO_DE_DOACAO, ponto);
};

export const cleanPontoEditar = ({ commit }, pontoEditar) => {
  commit(types.CLEAN_PONTO_EDITAR, pontoEditar);
};

export const obterPontoDeDoacoes = ({ dispatch, commit }) => {
  axios
    .get(`${BASE_URL}/pontos`)
    .then((response) => {
      const { data } = response;
      commit(types.OBTER_PONTO_DE_DOACOES, data.data);
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao obter Pontos de Coleta', {
        root: true
      });
    });
};

export const removerPonto = ({ dispatch, commit }, pontoId) => {
  axios
    .delete(`${BASE_URL}/pontos/${pontoId}`)
    .then(() => {
      commit(types.DELETE_PONTO_DE_DOACAO, pontoId);
      dispatch('alert/success', 'Ponto de Coleta excluido com sucesso!', {
        root: true
      });
    })
    .catch(() => {
      dispatch('alert/error', 'Desculpe, Não encontramos o Ponto de Coleta.', {
        root: true
      });
    });
};

export const getPontoByInst = ({ dispatch, commit }, instituicaoId) => {
  axios
    .get(`${BASE_URL}/instituicoes/${instituicaoId}/pontos`)
    .then((response) => {
      const { data } = response;
      commit(types.GET_PONTO_BY_INSTITUICAO, data.data);
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao obter os Ponto de Coleta.', {
        root: true
      });
    });
};

export const cadastraPontoDeDoacao = ({ dispatch, commit }, ponto) => {
  axios
    .post(`${BASE_URL}/pontos`, ponto)
    .then((response) => {
      const { data } = response;
      commit(types.ACRESCENTAR_PONTO_DE_DOACAO, data.data);
      dispatch('alert/success', 'Ponto de Coleta criado com sucesso!', {
        root: true
      });
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao criar o Ponto de Coleta.', {
        root: true
      });
    });
};

export const atualizarPonto = ({ dispatch, commit }, ponto) => {
  requisicaoAutorizada
    .patch(`${BASE_URL}/pontos/${ponto.id}`, ponto)
    .then(() => {
      commit(types.ATUALIZAR_PONTO_DE_DOACAO, ponto);
      dispatch('alert/success', 'Ponto foi atualizado com sucesso!', {
        root: true
      });
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao atualizar Ponto de Coleta', {
        root: true
      });
    });
};

export const getPonto = ({ dispatch, commit }, ponto) =>
  requisicaoAutorizada
    .patch(`${BASE_URL}/pontos/${ponto.id}`)
    .then((ponto) => {
      commit(types.ATUALIZAR_PONTO_DE_DOACAO, ponto);
      dispatch('alert/success', 'Ponto obtido com sucesso!', { root: true });
    })
    .catch(() => {
      dispatch('alert/error', 'Falha ao obter o Ponto de Coleta!', {
        root: true
      });
    });
