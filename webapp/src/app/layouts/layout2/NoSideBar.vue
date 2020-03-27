<template>
  <v-app>
    <App-bar />
    <v-content>
      <!-- <alerta
        v-if="alert.message != null && alert.message_type != null"
        :color="alert.message_type"
        >{{ alert.message }}
      </alerta> -->
      <router-view />
    </v-content>
  </v-app>
</template>

<script>
import { mapState, mapActions } from 'vuex';
import AppBar from './../components/AppBar';
// import Alerta from '../../../@core/alert/Alerta';

export default {
  name: 'App',
  components: {
    // Alerta,
    AppBar
  },
  computed: {
    options() {
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
  mounted() {
    this.loading = true;
  },
  methods: {
    ...mapActions({
      clearAlert: 'alert/clear'
    })
  }
};
</script>
