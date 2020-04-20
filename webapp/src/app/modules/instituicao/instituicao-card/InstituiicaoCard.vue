<template>
  <v-container>
    <v-dialog v-model="modal" persistent max-width="320">
      <v-card>
        <v-card-title class="headline text-center">Tem certeza que deseja deletar esta instituição?</v-card-title>
        <v-card-text>Você esta prestes a deletar {{instituicao.nome}}</v-card-text>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="green darken-1" text @click="modal = false">Cancelar</v-btn>
          <v-btn color="red darken-1" text @click="deletar(instituicao.id)">Sim, quero deletar!</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-card max-width="300">
      <imagem
        imgWidth="300"
        imgHeight="100"
        :objectId="instituicao.id"
        objectName="instituicao"
        modelImage="cover"
        :newImage="instituicao.image"
        @setObject="setObject($event)"
      />
      <v-card-title class="headline text-center" v-text="instituicao.nome"></v-card-title>
      <v-card-text>Descrição da intituicao</v-card-text>
      <v-card-actions v-if="this.$route.path != '/configuracao'">
        <div class="flex-grow-1"></div>
        <v-btn icon :to="`/instituicao/${instituicao.id}`">
          <v-icon>store</v-icon>
        </v-btn>
        <v-btn icon @click="editar(instituicao)">
          <v-icon>edit</v-icon>
        </v-btn>
        <v-btn icon @click="show = !show">
          <v-icon>{{show ? 'keyboard_arrow_up' : 'keyboard_arrow_down'}}</v-icon>
        </v-btn>
      </v-card-actions>

      <v-card-actions v-else>
        <div class="flex-grow-1"></div>
        <v-btn icon @click="modal = true">
          <v-icon>delete</v-icon>
        </v-btn>
      </v-card-actions>

      <v-expand-transition>
        <div v-show="show">
          <v-card-text>
            <div>
              <b>Abre ás:</b>
              <v-chip class="ma-1" color="green lighten-1">{{ instituicao.hora_open }} hrs</v-chip>
            </div>
            <div>
              <b>Fecha ás:</b>
              <v-chip class="ma-1" color="red lighten-1">{{ instituicao.hora_close }} hrs</v-chip>
            </div>
            <div>
              <b>Localidade:</b>
              <v-chip class="ma-1">{{ instituicao.nm_cidade }} - {{instituicao.sg_estado}}</v-chip>
            </div>
            <hr class="mt-3 mb-3" />
            <v-row justify="center">
              <v-btn color="deep-purple accent-4" text @click="openMap(instituicao)">
                <v-icon>fa fa-map-marker-alt mr-2</v-icon>Abrir localização
              </v-btn>
            </v-row>
          </v-card-text>
        </div>
      </v-expand-transition>
    </v-card>
  </v-container>
</template>

<script>
import { mapActions } from 'vuex';
import imagem from '../../../../@core/image/components/Image';

export default {
  name: 'InstituicaoCard',
  components: { imagem },
  props: ['instituicao'],

  data () {
    return {
      show: false,
      dialog: false,
      modal: false
    };
  },

  methods: {
    ...mapActions({
      statusDialog: 'instituicao/setDialog',
      insitituicaoEditar: 'instituicao/insitituicaoEditar',
      setImage: 'instituicao/setImage',
      removerInstituicao: 'instituicao/removerInstituicao'
    }),

    editar (instituicao) {
      this.statusDialog(true);
      this.insitituicaoEditar(instituicao);
    },

    setObject (e) {
      this.setImage(e);
    },

    openDialog () {
      this.dialog = true;
    },

    deletar (instituicao) {
      this.removerInstituicao(instituicao);
    },

    openMap (geolocation) {
      window.open(`https://www.google.com/maps/search/${geolocation.cep}/@${geolocation.longitude},${geolocation.latitude}`)
    }
  }
};
</script>
