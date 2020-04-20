<template>
  <v-container>
    <v-row>
      <v-col cols="10" lg="12" xl="12" md="12">
        <v-row align="center" justify="center">
          <v-col cols="12">
            <div class="cover">
              <img src="http://via.placeholder.com/1600x400" alt />
            </div>
          </v-col>
        </v-row>
        <v-row>
          <v-col cols="12">
            <v-chip color="primary" label class="mr-3 mt-2">
              <h3 class="mt-1">{{ instituicao.nome }}</h3>
            </v-chip>
            <v-chip color="green darken-1" label class="mr-3 mt-2">
              <v-icon left color="white">fa fa-home</v-icon>
              <h3 class="mt-1 white--text">
                Localidade: {{ instituicao.nm_cidade }} -
                {{ instituicao.sg_estado }}
              </h3>
            </v-chip>
            <v-chip color="purple darken-1" label class="mt-2">
              <v-icon left color="white">fa fa-phone</v-icon>
              <h3 class="mt-1 white--text">Telefone: {{ instituicao.telefone }}</h3>
            </v-chip>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12">
            <v-card>
              <v-tabs v-model="tab" background-color="grey lighten-4" centered icons-and-text>
                <v-tabs-slider />

                <v-tab href="#tab-1">
                  Itens para Doação
                  <v-icon>fa fa-list</v-icon>
                </v-tab>

                <v-tab href="#tab-2">
                  Pontos de Coleta
                  <v-icon>favorite</v-icon>
                </v-tab>

                <v-tab href="#tab-3">
                  Eventos
                  <v-icon>fa fa-calendar-alt</v-icon>
                </v-tab>
              </v-tabs>

              <v-tabs-items v-model="tab">
                <v-tab-item value="tab-1">
                  <v-card flat>
                    <v-card-text>
                      <div class="ma-9">
                        <h1 class="mb-3">Olá! Seja Bem-vindo,</h1>
                        <p>
                          Caso tenha o interesse de contribuir com a doação de algum item para esta
                          instituição, basta pesquisar na tabela a baixo. Nesta tabela representa quais itens a mesma está
                          necessitando. Após decidir que deseja contrituir basta entrar em contato através de seu telefone
                          logo a cima.
                        </p>
                      </div>

                      <DatatableItens :itens="{itens}" />
                    </v-card-text>
                  </v-card>
                </v-tab-item>

                <v-tab-item value="tab-2">
                  <v-row justify="center" align="center" v-if="pontos.length">
                    <v-col xl="3" md="5" lg="4" cols="12" v-for="ponto in pontos" :key="ponto.id">
                      <div class="ma-5">
                        <PontoCard :ponto="ponto" />
                      </div>
                    </v-col>
                  </v-row>
                  <v-row justify="center" align="center" style="height: 300px" v-else>
                    <p>Está instituição não possui pontos de coleta no momento.</p>
                  </v-row>
                </v-tab-item>

                <v-tab-item value="tab-3">
                  <v-row justify="center" align="center" v-if="eventos.length">
                    <v-col
                      xl="3"
                      md="5"
                      lg="4"
                      cols="12"
                      v-for="evento in eventos"
                      :key="evento.id"
                    >
                      <div class="ma-5">
                        <EventoCard :evento="evento" />
                      </div>
                    </v-col>
                  </v-row>
                  <v-row justify="center" align="center" style="height: 300px" v-else>
                    <p>Está instituição não possui eventos no momento.</p>
                  </v-row>
                </v-tab-item>
              </v-tabs-items>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import EventoCard from '../../evento/evento-card/EventoCard';
import PontoCard from '../../ponto/ponto-card/PontoCard';
import DatatableItens from '@/app/modules/item/datatable-itens/DatatableItens.vue'

export default {
  name: 'InstituicaoPerfil',
  components: { EventoCard, PontoCard, DatatableItens },

  data () {
    return {
      menuShow: true,
      tab: null,
    };
  },

  computed: {
    ...mapGetters({
      instituicao: 'instituicao/getInstiEncontrada',
      eventos: 'evento/getEventosInsti',
      pontos: 'ponto/ponto',
      itens: 'item/itensInstituicao'
    })
  },

  created () {
    this.buscarInsituicao(this.$route.params.id);
    this.obterEventosInstiuicao(this.$route.params.id);
    this.getPontoByInst(this.$route.params.id);
    this.getItensInstituicao(this.$route.params.id)
  },

  methods: {
    ...mapActions({
      buscarInsituicao: 'instituicao/buscartInstituicao',
      obterEventosInstiuicao: 'evento/obterEventosInstiuicao',
      getPontoByInst: 'ponto/getPontoByInst',
      getItensInstituicao: 'item/getItensInstituicao'
    })
  }
};
</script>

<style scoped>
.cover img {
  width: 100%;
}

.cover > a {
  display: inline-block;
  color: #e44d3a;
  font-size: 16px;
  background-color: #fff;
  border: 1px solid #e44d3a;
  position: absolute;
  top: 20px;
  right: 0;
  padding: 10px 15px;
  font-weight: 600;
  margin-right: 15px;
}

.cover > a i {
  padding-right: 5px;
}
</style>
