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
