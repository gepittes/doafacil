<template>
  <v-container>
    <v-card class="mx-auto mt-5" height="800" outlined>
      <v-row justify="center" align="center">
        <v-col xl="3" md="4" cols="12">
          <v-select
            v-model="instiSelected"
            :items="instituicoes"
            item-text="nome"
            menu-props="auto"
            label="Selecione uma instituição"
            hide-details
            prepend-icon="list"
            single-line
            color="green"
            autofocus
          />
        </v-col>
      </v-row>
      <v-divider class="ma-5" />
      <v-col>
        <DatatableItens :itens="{itens}" :instituicao="{...ObjInstiSelect}" />
      </v-col>
    </v-card>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import DatatableItens from '../datatable-itens/DatatableItens.vue'

export default {
  name: 'ItensInstituicao',
  components: { DatatableItens },
  data () {
    return {
      instiSelected: {},
      ObjInstiSelect: {}
    };
  },

  watch: {
    instiSelected () {
      this.ObjInstiSelect = this.instituicoes.filter(inst => inst.nome === this.instiSelected)[0]
      this.getItensInstituicao(this.ObjInstiSelect.id)
    }
  },

  computed: {
    ...mapGetters({
      instituicoes: 'instituicao/instituicao',
      accountInfo: 'account/accountInfo',
      itens: 'item/itensInstituicao'
    })
  },


  created () {
    this.obterInstiUser(this.accountInfo.user_id);
  },

  methods: {
    ...mapActions({
      obterInstiUser: 'instituicao/obterInstiUser',
      getItensInstituicao: 'item/getItensInstituicao'
    }),
  }
};
</script>
