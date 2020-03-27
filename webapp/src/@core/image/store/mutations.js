import * as types from './types';

export const mutations = {
  [types.UPLOAD_IMAGE](state, object) {
    state.object = object;
  }
};
