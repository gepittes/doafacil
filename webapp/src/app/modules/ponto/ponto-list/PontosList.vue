<template>
  <v-container>
    <v-row justify="center" align="center">
      <v-col xl="3" md="3">
        <v-subheader class="text-uppercase font-weight-bold">Instituição Selecionada:</v-subheader>
      </v-col>
      <v-col xl="4" md="4" cols="12">
        <v-select
          :items="instituicoes"
          v-model="instiSelected"
          item-text="nome"
          item-value="id"
          menu-props="auto"
          label="Selecione uma instituição"
          hide-details
          prepend-icon="list"
          single-line
          color="green"
          autofocus
        />
      </v-col>
      <v-col class="text-center" xl="2" md="3">
        <v-btn
          v-if="!isVisible"
          :disabled="isDisable"
          rounded
          color="green"
          dark
          @click="openPainel"
        >Adicionar</v-btn>
      </v-col>
    </v-row>

    <v-row justify="center">
      <v-col xl="12">
        <v-expand-transition>
          <v-expansion-panels
            v-if="isVisible"
            :value="statusPainel"
            :disabled="isDisable"
            class="mb-3"
          >
            <v-expansion-panel>
              <v-expansion-panel-header expand-icon="fa fa-plus">Criar um Ponto de Coleta</v-expansion-panel-header>
              <v-expansion-panel-content>
                <PontoFormulario :insti-selected="instiSelected" />
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>
        </v-expand-transition>

        <v-expansion-panels :disabled="isDisable" class="mb-3">
          <v-expansion-panel>
            <v-expansion-panel-header>Gerenciar Pontos de Coleta</v-expansion-panel-header>
            <v-expansion-panel-content>
              <v-container>
                <v-row justify="center">
                  <v-col v-for="ponto in pontos" :key="ponto.id" xl="3" md="4">
                    <PontoCard :ponto="ponto" :update="update" />
                  </v-col>
                </v-row>
              </v-container>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import PontoCard from '@/app/modules/ponto/ponto-card/PontoCard.vue'
import PontoFormulario from '@/app/modules/ponto/ponto-form/PontoFormulario';

export default {
  name: 'PontosList',
  components: { PontoCard, PontoFormulario },

  data () {
    return {
      isVisible: false,
      isDisable: true,
      instiSelected: {},
      pontoEditar: {}
    };
  },

  computed: {
    ...mapGetters({
      instituicoes: 'instituicao/instituicao',
      pontos: 'ponto/ponto',
      accountInfo: 'account/accountInfo',
      statusPainel: 'ponto/statusPainel'
    })
  },

  watch: {
    instiSelected () {
      if (this.instiSelected) {
        this.isDisable = false;
        this.getPontoByInst(this.instiSelected);
      }
    }
  },

  created () {
    this.obterInstiUser(this.accountInfo.user_id);
  },

  methods: {
    ...mapActions({
      obterInstiUser: 'instituicao/obterInstiUser',
      getPontoByInst: 'ponto/getPontoByInst',
      setPontoEditar: 'ponto/setPontoEditar',
      setStatusPainel: 'ponto/setStatusPainel'
    }),

    openPainel () {
      this.isVisible = !this.isVisible;
      setTimeout(() => {
        this.setStatusPainel(0)
      }, 300);
    },

    update (ponto) {
      this.isVisible = true;
      setTimeout(() => {
        this.statusPainel = 0;
      }, 300);
      this.setPontoEditar(ponto);
    }
  }
};
</script>
