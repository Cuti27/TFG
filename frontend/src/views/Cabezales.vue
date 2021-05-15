<template>
  <div>
    <!-- Header -->
    <header-custom name="Listado de cabezales"></header-custom>

    <div class="menu">
      <custom-button>Añadir cabezal</custom-button>
      <custom-button v-show="!remove" @click="remove = true"
        >Eliminar cabezal</custom-button
      >
      <custom-button v-show="remove" @click="remove = false"
        >Completar borrado</custom-button
      >
      <custom-button v-show="remove" @click="remove = false"
        >Cancelar</custom-button
      >
    </div>
    <div class="listado">
      <custom-table
        :remove="remove"
        :label="{ Id: 'id', Nombre: 'nombre', Fecha: 'fecha' }"
        :pageSize="5"
        countVuex="numCabezales"
        infoVuex="cabezales"
      >
      </custom-table>
    </div>
  </div>
</template>

<script>
import headerCustom from "@/components/Header";
import customTable from "@/components/CustomTable";
import customButton from "@/components/CustomButton";

export default {
  components: {
    headerCustom,
    customTable,
    customButton,
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
