<template>
  <v-container fluid>
    <v-row align="center" justify="center" class="main">
      <v-col cols="12" align="center">
        <MascoteGif :width="200" />
        <h1>Seja Bem-vindo(a)!</h1>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import MascoteGif from '@/app/layouts/components/MascoteGif.vue'

export default {
  name: 'MainPage',
  components: { MascoteGif },
  data () {
    return {
    }
  }
}
</script>

<style  scoped>
.main {
  height: 600px;
}
</style>

