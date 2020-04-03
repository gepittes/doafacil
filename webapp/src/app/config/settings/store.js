import Vue from 'vue';
import Vuex from 'vuex';

import account from '../../../app/modules/account';
import user from '../../modules/user';
import alert from '../../layouts/components/alert';
import conta from '../../modules/conta/store';
import instituicao from '../../modules/instituicao/store';
import ponto from '../../modules/ponto/store';
import evento from '../../modules/evento/store';
import image from './../../../@core/image/components/Image.vue';
import item from '../../modules/item/store';

Vue.use(Vuex);

export default new Vuex.Store({
  modules: {
    account,
    user,
    alert,
    conta,
    ponto,
    instituicao,
    evento,
    image,
    item
  },
  strict: true
});
