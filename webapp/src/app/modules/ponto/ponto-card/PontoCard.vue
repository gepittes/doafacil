<template>
  <v-container>
    <v-dialog v-model="dialog" persistent max-width="320">
      <v-card>
        <v-card-title class="headline text-center">Tem certeza que deseja deletar?</v-card-title>
        <v-card-actions>
          <div class="flex-grow-1"></div>
          <v-btn color="green darken-1" text @click="dialog = false">Cancelar</v-btn>
          <v-btn color="red darken-1" text @click="deletePonto(ponto.id)">Sim, quero deletar!</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-card width="400" outlined>
      <imagem
        imgWidth="300"
        imgHeight="100"
        :objectId="ponto.id"
        objectName="ponto"
        modelImage="cover"
        :newImage="ponto.image"
        @setObject="setObject($event)"
      />
      <v-card-title v-text="ponto.nome" />
      <v-card-text>
        <div>{{ ponto.descricao }}</div>
      </v-card-text>

      <v-divider class="mx-4 m-0" />

      <v-card-text>
        <p class="mb-0">
          Abre ás
          <b>{{ ponto.hora_open }}</b> e fecha ás
          <b>{{ ponto.hora_close }}</b>
        </p>
        <p class="mb-0">
          Local:
          <b>{{ponto.nm_cidade}} - {{ponto.sg_estado}}</b>
        </p>
      </v-card-text>

      <v-divider class="mx-4 m-0" />

      <v-card-actions>
        <v-row justify="center">
          <v-btn color="deep-purple accent-4" text @click="openMap(ponto)">
            <v-icon>fa fa-map-marker-alt mr-2</v-icon>Mapa do local
          </v-btn>
        </v-row>
      </v-card-actions>

      <v-card-actions>
        <div class="flex-grow-1"></div>
        <v-btn icon v-if="this.$route.name === `pontos`" @click="update(ponto)">
          <v-icon>edit</v-icon>
        </v-btn>
        <v-btn icon v-if="this.$route.name === `pontos`" @click="dialog = true">
          <v-icon>delete</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script>
import imagem from '../../../../@core/image/components/Image';
import { mapActions } from 'vuex';

export default {
  name: 'PontoCard',
  components: { imagem },
  props: {
    ponto: {
      type: Object,
      required: true
    },
  },
  data () {
    return {
      dialog: false,
      selection: 1
    };
  },
  methods: {
    ...mapActions({
      removerPonto: 'ponto/removerPonto',
      setImage: 'ponto/setImage',
      setPontoEditar: 'ponto/setPontoEditar',
      setStatusPainel: 'ponto/setStatusPainel'
    }),

    deletePonto (id) {
      this.dialog = false
      this.removerPonto(id);
    },

    setObject (e) {
      this.setImage(e);
    },

    update (ponto) {
      this.setStatusPainel(0)
      this.setPontoEditar(ponto)
    },

    openMap (geolocation) {
      window.open(`https://www.google.com/maps/search/${geolocation.cep}/@${geolocation.longitude},${geolocation.latitude}`)
    }
  }
};
</script>
