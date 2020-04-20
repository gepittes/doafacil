<template>
  <v-app>
    <v-container>
      <v-row>
        <v-col xs="12" cols="4" v-for="instituicao in instituicoesIniciais" :key="instituicao.id">
          <Instituicao :instituicao="instituicao" />
        </v-col>
      </v-row>

      <v-btn fab color="success" dark fixed bottom right @click="openDialog()">
        <v-icon>add</v-icon>
      </v-btn>
    </v-container>
    <InstituicaoFormulario />
  </v-app>
</template>
<script>
import { mapActions, mapGetters } from 'vuex';
import InstituicaoFormulario from './../instituicao-form/InstituicaoForm';
import Instituicao from '../instituicao-card/InstituiicaoCard';

export default {
  name: 'InstituicoesList',
  components: {
    InstituicaoFormulario,
    Instituicao
  },

  data () {
    return {
      instituicoesIniciais: [],
      instituicao: {}
    };
  },

  computed: {
    ...mapGetters({
      instituicoes: 'instituicao/instituicao',
      dialog: 'instituicao/getDialog',
      accountInfo: 'account/accountInfo'
    })
  },

  watch: {
    instituicoes (value) {
      if ('error' in value) {
        this.instituicoesIniciais = {};
      } else {
        this.instituicoesIniciais = value;
      }
    }
  },

  created () {
    this.obterInstiUser(this.accountInfo.user_id);
  },

  methods: {
    ...mapActions({
      obterInstiUser: 'instituicao/obterInstiUser',
      statusDialog: 'instituicao/setDialog'
    }),
    openDialog () {
      this.statusDialog(true);
    }
  }
};
</script>
