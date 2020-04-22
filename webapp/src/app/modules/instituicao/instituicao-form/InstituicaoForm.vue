<template>
  <v-dialog v-model="dialog" max-width="1000px" persistent>
    <v-card light>
      <v-container>
        <v-row justify="center">
          <v-col xs="12" md="11">
            <v-card-text>
              <div class="mb-5">
                <h1 v-if="!instituicao.id">Cadastrar Instituição</h1>
                <h1 v-else>Atualizar Instituição</h1>
              </div>

              <v-form ref="form" lazy-validation @submit.prevent="salvar()">
                <v-text-field v-if="false" v-model="instituicao.id" label="id" />

                <v-row>
                  <v-col>
                    <v-text-field
                      v-model="instituicao.nome"
                      required
                      :rules="[rules.required]"
                      label="Nome"
                    />
                  </v-col>
                  <v-col>
                    <v-text-field
                      v-model="instituicao.telefone"
                      v-mask="'(##) #####-####'"
                      required
                      :rules="[rules.required]"
                      label="Telefone"
                      return-masked-value
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
                      :return-value.sync="instituicao.hora_open"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="instituicao.hora_open"
                          label="Horário de Abertura:"
                          prepend-icon="access_time"
                          :rules="[rules.required]"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>
                      <v-time-picker
                        v-if="menuHoraOpen"
                        v-model="instituicao.hora_open"
                        full-width
                        format="24hr"
                        scrollable
                        @click:minute="
                      $refs.menuHoraOpen.save(instituicao.hora_open)
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
                      :return-value.sync="instituicao.hora_close"
                      transition="scale-transition"
                      offset-y
                      max-width="290px"
                      min-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          v-model="instituicao.hora_close"
                          label="Horário de Fechamento:"
                          prepend-icon="access_time"
                          :rules="[rules.required]"
                          readonly
                          v-on="on"
                        ></v-text-field>
                      </template>

                      <v-time-picker
                        v-if="menuHoraClose"
                        v-model="instituicao.hora_close"
                        full-width
                        format="24hr"
                        scrollable
                        @click:minute="
                      $refs.menuHoraClose.save(instituicao.hora_close)
                    "
                      ></v-time-picker>
                    </v-menu>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col>
                    <v-select
                      v-model="instituicao.estado"
                      required
                      item-text="nm_estado"
                      item-value="id"
                      @change="carregarCidades(instituicao.estado)"
                      :items="estados"
                      :rules="[rules.required]"
                      label="Estados"
                    ></v-select>
                  </v-col>
                  <v-col>
                    <v-select
                      v-model="instituicao.endereco.cidade_id"
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
                      v-model="instituicao.endereco.cep"
                      v-mask="'#####-###'"
                      required
                      :rules="[rules.required]"
                      label="CEP"
                      @change="getLocation(instituicao.endereco.cep)"
                      return-masked-value
                    />
                  </v-col>
                  <v-col>
                    <v-text-field
                      v-model="instituicao.endereco.bairro"
                      :value="instituicao.endereco.complemento"
                      required
                      :rules="[rules.required]"
                      label="Bairro"
                    />
                  </v-col>
                </v-row>

                <v-row>
                  <v-col>
                    <v-text-field
                      v-model="instituicao.endereco.logradouro"
                      :value="instituicao.endereco.logradouro"
                      required
                      :rules="[rules.required]"
                      label="Endereço"
                    />
                  </v-col>
                  <v-col>
                    <v-text-field
                      v-model="instituicao.endereco.complemento"
                      :value="instituicao.endereco.complemento"
                      required
                      :rules="[rules.required]"
                      label="Complemento"
                    />
                  </v-col>
                </v-row>

                <v-row justify="center">
                  <v-col>
                    <p>Aonde se encontra sua Instituição?</p>
                    <v-chip v-if="alertLocation" color="red" class="mb-4" dark>
                      <b>Por favor informe a localização</b>
                    </v-chip>
                    <v-lazy
                      :options="{threshold: 1.0}"
                      min-height="200"
                      transition="fade-transition"
                    >
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
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios';
import { cepAberto } from '@/@core/services/cepAbertoServices'
import { viaCep } from '@/@core/services/viaCepServices'
import { mapActions, mapGetters } from 'vuex';
import { mask } from 'vue-the-mask';
import MapBoxSearch from '@/@core/mapa/MapBoxSearch'

export default {
  name: 'InstituicaoForm',
  directives: { mask },
  components: { MapBoxSearch },

  data () {
    return {
      menuHoraOpen: false,
      menuHoraClose: false,
      submitted: false,
      alertLocation: false,
      instituicao: { endereco: { logradouro: '', bairro: '', complemento: '' } },
      instituicaoInicial: {
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
      dialog: 'instituicao/getDialog',
      accountInfo: 'account/accountInfo',
      getInstituicaoEditar: 'instituicao/getInstituicaEditar'
    }),
  },

  watch: {
    getInstituicaoEditar (value) {
      this.instituicao = {
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
      this.instituicao.endereco.cep != null && this.carregarCidades(this.instituicao.estado_id)
      this.instituicao.endereco.cidade_id = value.cidade_id;
    }
  },

  created () {
    this.carregarEstados();
  },

  methods: {
    ...mapActions({
      cadastrarInstituicao: 'instituicao/cadastrarInstituicao',
      atualizarInstituicao: 'instituicao/atualizarInstituicao',
      insitituicaoEditar: 'instituicao/insitituicaoEditar',
      statusDialog: 'instituicao/setDialog'
    }),

    closeDialog () {
      this.statusDialog(false);
      this.reset();
      this.resetValidation();
      this.insitituicaoEditar({ ...this.instituicaoInicial });
    },

    resetValidation () {
      this.$refs.form.resetValidation();
    },

    reset () {
      this.instituicao = { ...this.instituicaoInicial };
    },

    salvar () {
      this.submitted = true;

      if (this.$refs.form.validate() && this.checkHaveLocation()) {
        this.instituicao.usuario_id = this.accountInfo.user_id;
        this.alertLocation = false;

        if (this.instituicao.id) {
          this.atualizarInstituicao(this.instituicao);
        } else {
          this.cadastrarInstituicao(this.instituicao);
        }
        this.closeDialog();
      }
    },

    checkHaveLocation () {
      if (this.instituicao.endereco.longitude && this.instituicao.endereco.longitude) return true
      this.alertLocation = true
    },

    recivedLocationMap ({ latitude, longitude }) {
      this.instituicao.endereco.latitude = latitude
      this.instituicao.endereco.longitude = longitude
    },

    async getLocation (cep) {
      // cepAberto.get().then((resp) => console.log(resp))
      await viaCep.get(`${cep}/json`).then(({ data }) => {
        this.instituicao.endereco.logradouro = data.logradouro
        this.instituicao.endereco.complemento = data.complemento
        this.instituicao.endereco.bairro = data.bairro
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
