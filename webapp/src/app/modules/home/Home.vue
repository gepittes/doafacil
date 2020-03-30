<template>
  <v-app light>
    <BackTop />

    <Fachada :img-paralax="images.main" />
    <CompInfo />

    <Footer />
  </v-app>
</template>

<script>
import Fachada from './FachadaHome';
import CompInfo from './InfoCompany.vue';
import Footer from '../../layouts/components/Footer';
import BackTop from './BackTop';

export default {
  name: 'Home',
  components: { BackTop, Footer, CompInfo, Fachada },
  data: function () {
    return {
      images: {
        main: require("../../../assets/img/union-hands.jpg"),
        // logo: require('@/assets/doafacil/logos/logo-doafacil.png'),
      }
    };
  }
};
</script>
