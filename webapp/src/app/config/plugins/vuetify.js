import Vue from 'vue';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import '@fortawesome/fontawesome-free/css/all.css';

Vue.use(Vuetify);

import pt from 'vuetify/es5/locale/pt';

export default new Vuetify({
  theme: {
    dark: false
  },
  icons: {
    iconfont: 'fa'
  },
  lang: {
    locales: { pt },
    current: 'pt'
  }
});
