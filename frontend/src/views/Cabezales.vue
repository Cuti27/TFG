<template>
  <div>
    <!-- Header -->
    <header-custom name="Listado de cabezales"></header-custom>

    <table-cabezal></table-cabezal>
  </div>
</template>

<script>
import headerCustom from "@/components/Header";
// import customTable from "@/components/CustomTable";
import tableCabezal from "@/components/vuetify/tableCabezal";
import { mapActions } from "vuex";

export default {
  beforeMount() {
    this.start();
  },
  methods: {
    ...mapActions({
      start: "getCabezales", // map `this.add()` to `this.$store.dispatch('increment')`
    }),
  },
  components: {
    headerCustom,
    tableCabezal,
    // customTable,
  },
  data() {
    return {
      remove: false,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";
.menu {
  margin: 10px 50px;
  border-radius: 5px;
  box-shadow: $gray 0px 14px 28px, $gray 0px 10px 10px;
  background: $white;
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>
