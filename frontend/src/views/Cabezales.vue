<template>
  <div>
    <!-- Header -->
    <header-custom tour="cabezales" name="Listado de cabezales"></header-custom>

    <table-cabezal></table-cabezal>
  </div>
</template>

<script>
import headerCustom from "@/components/Header";
import tableCabezal from "@/components/vuetify/tableCabezal";
import { mapActions } from "vuex";

export default {
  beforeMount() {
    this.start();
    this.setTempProgram({});
  },
  methods: {
    ...mapActions({
      start: "getCabezales",
      setTempProgram: "setTempProgram",
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
