<template>
  <v-container fluid>
    <v-row align="start" justify="center" class="main">
      <v-col cols="12" align="center">
        <MascoteGif :width="150" />
        <h1>Seja Bem-vindo(a)!</h1>
      </v-col>
      <v-row>
        <v-col v-for="module in modules" :key="module.title" md="4">
          <ActionInfo
            :title="module.title"
            :text="module.text"
            :icon="module.icon"
            :link="module.link"
          />
        </v-col>
      </v-row>
    </v-row>
  </v-container>
</template>

<script>
import MascoteGif from '@/app/layouts/components/MascoteGif.vue'
import ActionInfo from './ActionInfo'

export default {
  name: 'MainPage',
  components: { MascoteGif, ActionInfo },
  data: () => ({
    modules: [
      {
        title: 'Cadastre Instituições',
        text: 'Clicando aqui vocẽ poderá cadastrar, atualizar e visualizar os dados de todos suas instituições.',
        icon: 'fa fa-home fa-3x',
        link: '/instituicoes'
      },
      {
        title: 'Pontos de Coleta',
        text: 'Cadastre os pontos de coleta onde suas instituições poderão estar recebendo os itens.',
        icon: 'fa fa-map fa-3x',
        link: '/pontos'
      },
      {
        title: 'Itens para Doação',
        text: 'Cadastre aqui itens que suas instituições estão precisando.',
        icon: 'fa fa-list-alt fa-3x',
        link: '/itens'
      },
      {
        title: 'Cadastre Eventos',
        text: 'Cadastre os eventos das suas instituições que irão aparacer a público em nossos mapas. ',
        icon: 'fa fa-calendar-alt fa-3x',
        link: '/eventos'
      },
    ]
  })
}
</script>

<style scoped>
.main {
  height: 600px;
}
</style>

