<template>
  <v-container>
    <v-row justify="center">
      <v-col>
        <v-card-text>
          <v-form ref="form" lazy-validation @submit.prevent="salvar()">
            <v-text-field v-if="false" v-model="ponto.id" label="id" />

            <v-row>
              <v-col>
                <v-text-field v-model="ponto.nome" required :rules="[rules.required]" label="Nome" />
              </v-col>
              <v-col>
                <v-text-field
                  v-model="ponto.descricao"
                  required
                  :rules="[rules.required]"
                  label="Descrição breve"
                />
              </v-col>
            </v-row>

            <v-row>
              <v-col>
                <v-menu
                  ref="menuHoraOpen"
                  v-model="menuHoraOpen"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="ponto.hora_open"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="ponto.hora_open"
                      label="Horário de Abertura:"
                      prepend-icon="access_time"
                      :rules="[rules.required]"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>
                  <v-time-picker
                    v-if="menuHoraOpen"
                    v-model="ponto.hora_open"
                    full-width
                    format="24hr"
                    scrollable
                    @click:minute="
                      $refs.menuHoraOpen.save(ponto.hora_open)
                    "
                  ></v-time-picker>
                </v-menu>
              </v-col>

              <v-col>
                <v-menu
                  ref="menuHoraClose"
                  v-model="menuHoraClose"
                  :close-on-content-click="false"
                  :nudge-right="45"
                  :return-value.sync="ponto.hora_close"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="ponto.hora_close"
                      label="Horário de Fechamento:"
                      prepend-icon="access_time"
                      :rules="[rules.required]"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>

                  <v-time-picker
                    v-if="menuHoraClose"
                    v-model="ponto.hora_close"
                    full-width
                    format="24hr"
                    scrollable
                    @click:minute="
                      $refs.menuHoraClose.save(ponto.hora_close)
                    "
                  ></v-time-picker>
                </v-menu>
              </v-col>
            </v-row>

            <v-row>
              <v-col>
                <v-select
                  v-model="ponto.estado"
                  required
                  item-text="nm_estado"
                  item-value="id"
                  @change="carregarCidades(ponto.estado)"
                  :items="estados"
                  :rules="[rules.required]"
                  label="Estados"
                ></v-select>
              </v-col>
              <v-col>
                <v-select
                  v-model="ponto.endereco.cidade_id"
                  required
                  item-text="nm_cidade"
                  item-value="id"
                  :rules="[rules.required]"
                  :items="cidades"
                  label="Cidades"
                ></v-select>
              </v-col>
            </v-row>

            <v-row>
              <v-col>
                <v-text-field
                  v-model="ponto.endereco.cep"
                  v-mask="'#####-###'"
                  required
                  :rules="[rules.required]"
                  label="CEP"
                  @change="getLocation(ponto.endereco.cep)"
                  return-masked-value
                />
              </v-col>
              <v-col>
                <v-text-field
                  v-model="ponto.endereco.bairro"
                  :value="ponto.endereco.complemento"
                  required
                  :rules="[rules.required]"
                  label="Bairro"
                />
              </v-col>
            </v-row>

            <v-row>
              <v-col>
                <v-text-field
                  v-model="ponto.endereco.logradouro"
                  :value="ponto.endereco.logradouro"
                  required
                  :rules="[rules.required]"
                  label="Endereço"
                />
              </v-col>
              <v-col>
                <v-text-field
                  v-model="ponto.endereco.complemento"
                  :value="ponto.endereco.complemento"
                  required
                  :rules="[rules.required]"
                  label="Complemento"
                />
              </v-col>
            </v-row>

            <v-row justify="center">
              <v-col>
                <p>Aonde se encontra este Ponto de Coleta?</p>
                <v-chip v-if="alertLocation" color="red" class="mb-4" dark>
                  <b>Por favor informe a localização</b>
                </v-chip>
                <v-lazy :options="{threshold: 1.0}" min-height="200" transition="fade-transition">
                  <MapBoxSearch @localizacao="recivedLocationMap($event)" />
                </v-lazy>
              </v-col>
            </v-row>

            <v-card-actions>
              <div class="flex-grow-1"></div>
              <v-btn color="secundary" type="cancel" class="ma ma-1" @click="closeDialog">Fechar</v-btn>
              <v-btn class="ma ma-1" color="primary" type="submit">Salvar</v-btn>
            </v-card-actions>
          </v-form>
        </v-card-text>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axios from 'axios';
import { cepAberto } from '@/@core/services/cepAbertoServices'
import { viaCep } from '@/@core/services/viaCepServices'
import { mapActions, mapGetters } from 'vuex';
import { mask } from 'vue-the-mask';
import MapBoxSearch from '@/@core/mapa/MapBoxSearch'

export default {
  name: 'PontoForm',
  props: ['instiSelected'],
  directives: { mask },
  components: { MapBoxSearch },

  data () {
    return {
      menuHoraOpen: false,
      menuHoraClose: false,
      submitted: false,
      alertLocation: false,
      ponto: { endereco: { logradouro: '', bairro: '', complemento: '' } },
      pontoInicial: {
        endereco: {
          logradouro: '',
          bairro: '',
          complemento: '',
          cep: null,
          longitude: '',
          latitude: '',
          cidade_id: ''
        }
      },
      estados: [],
      cidades: [],
      rules: { required: (value) => !!value || 'Campo Obrigatório.' }
    };
  },

  computed: {
    ...mapGetters({
      accountInfo: 'account/accountInfo',
      pontoEditar: 'ponto/pontoEditar',
    }),
  },

  watch: {
    pontoEditar (value) {
      this.ponto = {
        ...value,
        estado: value.estado_id,
        endereco: {
          bairro: value.bairro,
          logradouro: value.logradouro,
          complemento: value.complemento,
          cep: value.cep,
          longitude: value.longitude,
          latitude: value.latitude,
        }
      }
      this.ponto.endereco.cep != null && this.carregarCidades(this.ponto.estado_id)
      this.ponto.endereco.cidade_id = value.cidade_id;
    }
  },

  created () {
    this.carregarEstados();
  },

  methods: {
    ...mapActions({
      cadastraPontoDeDoacao: 'ponto/cadastraPontoDeDoacao',
      atualizarPonto: 'ponto/atualizarPonto',
      setPontoEditar: 'ponto/setPontoEditar',
      setStatusPainel: 'ponto/setStatusPainel'
    }),

    closeDialog () {
      this.reset();
      this.resetValidation();
      this.setPontoEditar({ ...this.pontoInicial });
      this.setStatusPainel([])
    },

    resetValidation () {
      this.$refs.form.resetValidation();
    },

    reset () {
      this.instituicao = { ...this.instituicaoInicial };
    },

    salvar () {
      this.submitted = true;
      this.ponto.instituicao_id = this.instiSelected

      if (this.$refs.form.validate() && this.checkHaveLocation()) {
        this.ponto.usuario_id = this.accountInfo.user_id;
        this.alertLocation = false;

        if (this.ponto.id) {
          this.atualizarPonto(this.ponto);
        } else {
          this.cadastraPontoDeDoacao(this.ponto);
        }
        this.closeDialog();
      }
    },

    checkHaveLocation () {
      if (this.ponto.endereco.longitude && this.ponto.endereco.longitude) return true
      this.alertLocation = true
    },

    recivedLocationMap ({ latitude, longitude }) {
      this.ponto.endereco.latitude = latitude
      this.ponto.endereco.longitude = longitude
    },

    async getLocation (cep) {
      // cepAberto.get().then((resp) => console.log(resp))
      await viaCep.get(`${cep}/json`).then(({ data }) => {
        this.ponto.endereco.logradouro = data.logradouro
        this.ponto.endereco.complemento = data.complemento
        this.ponto.endereco.bairro = data.bairro
      })
    },

    async carregarEstados () {
      await axios.get('http://localhost/v1/estados')
        .then(({ data }) => this.estados = [...data.data]);
    },

    async carregarCidades (id) {
      await axios.get(`http://localhost/v1/estados/${id}/cidades`)
        .then(({ data }) => this.cidades = [...data.data]);
    }
  }
};
</script>
