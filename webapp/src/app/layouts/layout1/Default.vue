<template>
  <v-app>
    <app-bar class="mb-5" />
    <v-container class="mt-4" grid-list-md>
      <v-layout row wrap>
        <v-row justify="center">
          <v-col cols="3" md="3" lg="2" xl="2" v-if="menu" class="pa-0">
            <menu-instituicao :show-avatar="false" />
          </v-col>
          <v-col :cols="main" md="9" lg="10" xl="8" class="pa-0 mb-2">
            <router-view />
          </v-col>
        </v-row>
      </v-layout>
      <alerta
        v-if="alert.message != null && alert.message_type != null"
        :color="alert.message_type"
      >{{ alert.message }}</alerta>
    </v-container>
  </v-app>
</template>
<script>
import { mapState, mapActions } from 'vuex';
import AppBar from '../components/AppBar';
import MenuInstituicao from '../../config/navigation/MenuInstituicao';
import Alerta from '../components/alert/Alerta';

export default {
  name: 'Main',
  components: {
    MenuInstituicao,
    Alerta,
    AppBar
  },
  data () {
    return {
      window: {
        width: 0
      },
      menu: true,
      main: 9
    };
  },
  watch: {
    'window.width': function (width) {
      if (width < 700) {
        this.menu = false;
        this.main = 12;
      }
      if (width > 700) {
        this.menu = true;
        this.main = 9;
      }
      this.window.width = width;
    }
  },
  created () {
    window.addEventListener('resize', this.handleResize);
    this.handleResize();
  },

  computed: {
    options () {
      return {
        duration: 1300,
        offset: 0,
        easing: 'easeInOutCubic'
      };
    },
    ...mapState({
      alert: (state) => state.alert
      // isLoggedIn: state => state.isLoggedIn
      // status: state => state.status
    })
  },
  mounted () {
    this.loading = true;
  },
  methods: {
    ...mapActions({
      clearAlert: 'alert/clear'
    }),

    handleResize () {
      this.window.width = window.innerWidth;
    }
  }
};
</script>
