<template>
  <v-app light>
    <BackTop />

    <Fachada :img-paralax="images.main" />
    <section>
      <v-col align="center" class="ma-9">
        <v-row justify="center">
          <h1 class="display-1">Encontre Instituições perto de você!</h1>
        </v-row>
        <v-row justify="center">
          <h3
            class="headline grey--text mt-2"
          >Use o mapa a baixo para descobrir instituições em sua proximidade</h3>
        </v-row>
      </v-col>
      <v-row justify="center">
        <v-col md="10">
          <v-lazy :options="{threshold: 1.0}" min-height="200" transition="fade-transition">
            <MapBoxList :markers="instituicoes" />
          </v-lazy>
        </v-col>
      </v-row>
    </section>
    <CompInfo />

    <Footer />
  </v-app>
</template>

<script>
import Fachada from './FachadaHome';
import CompInfo from './InfoCompany.vue';
import Footer from '../../layouts/components/Footer';
import BackTop from './BackTop';
import MapBoxList from '@/@core/mapa/MapBoxList'
import { mapActions, mapGetters } from 'vuex'

export default {
  name: 'Home',
  components: { BackTop, Footer, CompInfo, Fachada, MapBoxList },

  data: () => {
    return {
      images: {
        main: require("../../../assets/img/union-hands.jpg"),
      }
    };
  },

  methods: {
    ...mapActions({
      getInstituicoes: 'instituicao/obterInstituicoes'
    })
  },

  computed: {
    ...mapGetters({
      instituicoes: 'instituicao/instituicao'
    })
  },

  created () {
    this.getInstituicoes()
  }
};
</script>
