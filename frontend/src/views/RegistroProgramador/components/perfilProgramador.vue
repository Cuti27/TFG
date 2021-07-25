<template>
  <div class="perfil mb-5 mx-5">
    <v-card width="100%" min-width="100%">
      <v-img
        class="white--text align-center"
        height="200px"
        gradient="to top right, rgba(69, 97, 133, 0.9), rgba(69, 97, 133, 0.5)"
        :src="img"
      >
        <v-card-title class="align-center justify-center"
          >{{ type }} - {{ name }}</v-card-title
        >
        <v-card-subtitle v-if="id" class="pb-0 white--text">
          {{ id }}
        </v-card-subtitle>
        <v-card-text class="text--primary">
          <div class="white--text align-center">
            Cabezal: {{ headName }} - {{ headId }}
          </div>

          <div class="white--text align-center">
            Última actualización: {{ date }}
          </div>
        </v-card-text>
      </v-img>
    </v-card>
  </div>
</template>

<script>
export default {
  props: {
    img: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    id: {
      type: String || Number,
    },
    headName: {
      type: String,
      required: true,
    },
    headId: {
      type: Number,
    },
    date: {
      type: String,
      required: true,
    },
  },
};
</script>

<style scoped>
.perfil {
  min-width: 100%;
}
</style>