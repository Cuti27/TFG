<template>
  <v-footer v-bind="localAttrs" :padless="padless">
    <v-card
      flat
      tile
      width="100%"
      class="lighten-1 text-center"
      color="primary"
    >
      <v-card-text>
        <v-btn
          v-for="(icon, index) in icons"
          :key="icon"
          class="mx-4"
          :href="ref[index]"
          icon
        >
          <font-awesome-icon :icon="icon" size="lg"></font-awesome-icon>
        </v-btn>
      </v-card-text>

      <v-divider></v-divider>

      <v-card-text class="white--text">
        {{ new Date().getFullYear() }} — <strong>Genhidro</strong>
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
export default {
  data: () => ({
    icons: [
      ["fa", "home"],
      ["fab", "linkedin-in"],
      ["fab", "facebook-f"],
      ["fa", "info-circle"],
    ],
    ref: [
      "/",
      "https://www.linkedin.com/company/agrosolmen/",
      "https://es-es.facebook.com/pages/category/Agricultural-Cooperative/Agrosolmen-1461731994040377/",
      "https://agrosolmen.es/",
    ],
    padless: false,
    variant: "default",
  }),
  computed: {
    localAttrs() {
      const attrs = {};

      if (this.variant === "default") {
        attrs.absolute = false;
        attrs.fixed = false;
      } else {
        attrs[this.variant] = true;
      }
      return attrs;
    },
  },
};
</script>

<style lang="scss" scoped>
$color-pack: false;

  @import '@/css/colorSchema.scss';
</style>
