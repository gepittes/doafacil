<template>
  <v-container>
    <v-row justify="center">
      <v-col>
        <v-card-text>
          <v-form ref="form" lazy-validation @submit.prevent="salvar()">
            <v-text-field v-if="false" v-model="evento.id" label="id" />

            <v-row>
              <v-col>
                <v-text-field
                  v-model="evento.nome"
                  required
                  :rules="[rules.required]"
                  label="Nome"
                />
              </v-col>
              <v-col>
                <v-text-field
                  v-model="evento.descricao"
                  required
                  :rules="[rules.required]"
                  label="Descrição breve"
                />
              </v-col>
            </v-row>

            <v-row>
              <v-col>
                <v-dialog
                  ref="dialog_data"
                  v-model="modalData"
                  :return-value.sync="evento.data"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="evento.data"
                      label="Selecione a data:"
                      prepend-icon="event"
                      :rules="[rules.required]"
                      readonly
                      v-on="on"
                      hint="MM/DD/YYYY format"
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="evento.data"
                    scrollable
                    color="green lighten-1"
                    locale="Brazil"
                  >
                    <div class="flex-grow-1"></div>
                    <v-btn text color="primary" @click="modalData = false">Cancelar</v-btn>
                    <v-btn text color="primary" @click="$refs.dialog_data.save(evento.data)">OK</v-btn>
                  </v-date-picker>
                </v-dialog>
              </v-col>

              <v-col>
                <v-menu
                  ref="menuHora"
                  v-model="menuHora"
                  :close-on-content-click="false"
                  :nudge-right="45"
                  :return-value.sync="evento.hora"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      v-model="evento.hora"
                      label="Horário do Evento:"
                      prepend-icon="access_time"
                      :rules="[rules.required]"
                      readonly
                      v-on="on"
                    ></v-text-field>
                  </template>

                  <v-time-picker
                    v-if="menuHora"
                    v-model="evento.hora"
                    full-width
                    format="24hr"
                    scrollable
                    @click:minute="
                      $refs.menuHora.save(evento.hora)
                    "
                  ></v-time-picker>
                </v-menu>
              </v-col>
            </v-row>

            <v-row>
              <v-col>
                <v-select
                  v-model="evento.estado"
                  required
                  item-text="nm_estado"
                  item-value="id"
                  @change="carregarCidades(evento.estado)"
                  :items="estados"
                  :rules="[rules.required]"
                  label="Estados"
                ></v-select>
              </v-col>
              <v-col>
                <v-select
                  v-model="evento.endereco.cidade_id"
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
                  v-model="evento.endereco.cep"
                  v-mask="'#####-###'"
                  required
                  :rules="[rules.required]"
                  label="CEP"
                  @change="getLocation(evento.endereco.cep)"
                  return-masked-value
                />
              </v-col>
              <v-col>
                <v-text-field
                  v-model="evento.endereco.bairro"
                  :value="evento.endereco.complemento"
                  required
                  :rules="[rules.required]"
                  label="Bairro"
                />
              </v-col>
            </v-row>

            <v-row>
              <v-col>
                <v-text-field
                  v-model="evento.endereco.logradouro"
                  :value="evento.endereco.logradouro"
                  required
                  :rules="[rules.required]"
                  label="Endereço"
                />
              </v-col>
              <v-col>
                <v-text-field
                  v-model="evento.endereco.complemento"
                  :value="evento.endereco.complemento"
                  required
                  :rules="[rules.required]"
                  label="Complemento"
                />
              </v-col>
            </v-row>

            <v-row justify="center">
              <v-col>
                <p>Aonde ocorrerá o Evento?</p>
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
  name: 'EventoForm',
  props: ['instiSelected'],
  directives: { mask },
  components: { MapBoxSearch },

  data () {
    return {
      menuHora: false,
      modalData: false,
      submitted: false,
      alertLocation: false,
      evento: { endereco: { logradouro: '', bairro: '', complemento: '' } },
      eventoInicial: {
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
      getEventoEditar: 'evento/getEventoEditar'
    })
  },

  watch: {
    getEventoEditar (value) {
      this.evento = {
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
      this.evento.endereco.cep != null && this.carregarCidades(this.evento.estado_id)
      this.evento.endereco.cidade_id = value.cidade_id;
    }
  },

  created () {
    this.carregarEstados();
  },

  methods: {
    ...mapActions({
      statusPnlCreate: 'evento/statusPnlCreate',
      criarEvento: 'evento/criarEvento',
      setPainelList: 'evento/statusPnlList',
      eventoEditar: 'evento/eventoEditar',
      atualizarEvento: 'evento/atualizarEvento'
    }),

    closeDialog () {
      this.reset();
      this.resetValidation();
      this.eventoEditar({ ...this.pontoInicial });
      this.statusPnlCreate([]);
    },

    resetValidation () {
      this.$refs.form.resetValidation();
    },

    reset () {
      this.evento = { ...this.eventoInicial };
    },

    salvar () {
      this.submitted = true;
      this.evento.instituicao_id = this.instiSelected.id

      if (this.$refs.form.validate() && this.checkHaveLocation()) {
        this.evento.usuario_id = this.accountInfo.user_id;
        this.alertLocation = false;

        if (this.evento.id) {
          this.atualizarEvento(this.evento);
        } else {
          this.criarEvento(this.evento);
        }
        this.closeDialog();
      }
    },

    checkHaveLocation () {
      if (this.evento.endereco.longitude && this.evento.endereco.longitude) return true
      this.alertLocation = true
    },

    recivedLocationMap ({ latitude, longitude }) {
      this.evento.endereco.latitude = latitude
      this.evento.endereco.longitude = longitude
    },

    async getLocation (cep) {
      // cepAberto.get().then((resp) => console.log(resp))
      await viaCep.get(`${cep}/json`).then(({ data }) => {
        this.evento.endereco.logradouro = data.logradouro
        this.evento.endereco.complemento = data.complemento
        this.evento.endereco.bairro = data.bairro
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
