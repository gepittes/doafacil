import './app/config/plugins/doafacil';
import './app/config/plugins/bootstrap';
import './app/config/plugins/mapbox';
import vuetify from './app/config/plugins/vuetify';
import '@babel/polyfill';
import Vue from 'vue';
import App from './app/layouts/App';
import router from './app/config/navigation/router';
import store from './app/config/settings/store';
import filters from './@core/utils/filters';

import Default from './app/layouts/layout1/Default.vue';
import NoSideBar from './app/layouts/layout2/NoSideBar.vue';
import './registerServiceWorker';

Vue.component('default-layout', Default);
Vue.component('no-side-bar-layout', NoSideBar);

filters.create(Vue);

new Vue({
  vuetify,
  router,
  store,
  filters,
  render: (h) => h(App)
}).$mount('#app');
