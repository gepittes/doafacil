<template>
  <v-app>
    <v-container fluid grid-list-md>
      <v-expansion-panels v-model="panel" multiple focusable class="mt-5">
        <v-expansion-panel>
          <v-expansion-panel-header>Conta</v-expansion-panel-header>
          <v-expansion-panel-content>
            <meu-cadastro :open-painel="openPainel" />
          </v-expansion-panel-content>
        </v-expansion-panel>

        <v-expansion-panel>
          <v-expansion-panel-header>Minhas Instituicões</v-expansion-panel-header>
          <v-expansion-panel-content>
            <v-row>
              <v-col xs="12" cols="4" v-for="instituicao in instituicoes" :key="instituicao.id">
                <Instituicao :instituicao="instituicao" />
              </v-col>
            </v-row>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-container>
  </v-app>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import MeuCadastro from '@/app/modules/conta/conta-perfil/MeuCadastro.vue'
import Instituicao from '@/app/modules/instituicao/instituicao-card/InstituicaoCard.vue'

export default {
  name: 'Configuracao',
  components: { Instituicao, MeuCadastro },
  data () {
    return {
      panel: [],
    }
  },

  computed: {
    ...mapGetters({
      instituicoes: 'instituicao/instituicao',
      accountInfo: 'account/accountInfo',
    }),
  },

  methods: {
    ...mapActions({
      obterInstiUser: 'instituicao/obterInstiUser',
    }),

    openPainel (value) {
      this.panel = value
    },
  },
  created () {
    this.obterInstiUser(this.accountInfo.user_id)
  },
}
</script>
