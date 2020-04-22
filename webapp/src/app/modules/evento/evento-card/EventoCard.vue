<template>
  <v-container>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent max-width="320">
        <v-card>
          <v-card-title class="headline text-center">Tem certeza que deseja deletar este evento?</v-card-title>
          <v-card-actions>
            <div class="flex-grow-1"></div>
            <v-btn color="green darken-1" text @click="dialog = false">Cancelar</v-btn>
            <v-btn color="red darken-1" text @click="deletarEvento(evento.id)">Sim, quero deletar!</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
    <v-card max-width="400" outlined>
      <imagem
        imgWidth="300"
        imgHeight="100"
        :objectId="evento.id"
        objectName="evento"
        modelImage="cover"
        :newImage="evento.image"
        @setObject="setObject($event)"
      />

      <v-card-title>{{ evento.nome }}</v-card-title>
      <v-card-text>
        <div>{{ evento.descricao }}</div>
      </v-card-text>

      <v-divider class="mx-4 m-0" />

      <v-card-text>
        <v-row justify="center">
          <v-chip class="mb-0" color="green" dark>
            <span>
              <b>{{evento.data}}</b> ás
              <b>{{evento.hora}} hrs</b>
            </span>
          </v-chip>
          <p class="ma-2 text-center mb-0">
            <b>Endereço:</b>
            {{evento.logradouro}}, {{evento.bairro}},
            {{evento.complemento}}
          </p>
        </v-row>
      </v-card-text>

      <v-divider class="mx-4 m-0" />

      <v-card-actions>
        <v-row justify="center">
          <v-btn color="deep-purple accent-4" text @click="openMap(evento)">
            <v-icon>fa fa-map-marker-alt mr-2</v-icon>Mapa do local
          </v-btn>
        </v-row>
      </v-card-actions>

      <v-card-actions>
        <v-spacer />
        <v-btn v-if="this.$route.name === `eventos`" icon @click="editarEvento(evento)">
          <v-icon>edit</v-icon>
        </v-btn>
        <v-btn v-if="this.$route.name === `eventos`" icon @click="dialog = true">
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
  name: 'eventoCard',
  props: ['evento'],
  components: { imagem },
  data: () => ({
    selection: 1,
    dialog: false
  }),

  methods: {
    ...mapActions({
      deletarEvento: 'evento/deletarEvento',
      eventoEditar: 'evento/eventoEditar',
      statusPnlCreate: 'evento/statusPnlCreate',
      visibleCreatePnlEvento: 'evento/visibleCreatePnlEvento',
      setImage: 'evento/setImage'
    }),

    editarEvento (evento) {
      this.visibleCreatePnlEvento(true);
      this.statusPnlCreate(0);
      setTimeout(() => {
        this.eventoEditar(evento);
      }, 800);
    },

    openMap (geolocation) {
      window.open(`https://www.google.com/maps/search/${geolocation.cep}/@${geolocation.longitude},${geolocation.latitude}`)
    },

    setObject (e) {
      this.setImage(e);
    }
  }
};
</script>
