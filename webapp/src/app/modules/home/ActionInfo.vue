<template>
  <v-card class="mx-auto" max-width="350" height="130" outlined @click="redirect(link)">
    <v-list-item three-line>
      <v-list-item-content>
        <v-list-item-title class="title mb-3">{{title}}</v-list-item-title>
        <p class="text">{{text}}</p>
      </v-list-item-content>

      <v-list-item-avatar tile size="80" color="white">
        <i :class="icon" class="blue--text mt-5" />
      </v-list-item-avatar>
    </v-list-item>
  </v-card>
</template>

<script>
export default {
  name: 'ActionInfo',
  props: ['title', 'text', 'icon', 'link'],
  data: () => ({}),

  methods: {
    redirect (path) {
      this.$router.push(path)
    }
  }
}
</script>

<style>
.text {
  font-size: 15px;
  color: #6b6b6b;
}
</style>