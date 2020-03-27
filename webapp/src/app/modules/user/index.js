import * as actions from './actions';
import mutations from './mutations';
import state from './state';
import { userService } from './service';

export default {
  namespaced: true,
  actions,
  state,
  mutations,
  userService
};
