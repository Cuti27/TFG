<template>
  <div>
    <!-- Header -->
    <header-custom
      :name="`Listado de programas del cabezal: ${selectedHead.name}`"
    ></header-custom>

    <table-program></table-program>
  </div>
</template>

<script>
import headerCustom from "@/components/Header";
import tableProgram from "@/components/vuetify/tableProgram";
import { mapGetters } from "vuex";

export default {
  components: {
    headerCustom,
    tableProgram,
  },
  data() {
    return {
      remove: false,
    };
  },
  computed: {
    ...mapGetters(["selectedHead"]),
  },
};
</script>

<style lang="scss">
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

.customTable table .dayList .size {
  width: 35px;
  height: 35px;
  line-height: 35px;
}
</style>
