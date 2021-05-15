<template>
  <div>
    <!-- Header -->
    <header-custom name="Listado de cabezales"></header-custom>

    <div class="menu">
      <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5" >Añadir nuevo programa</v-btn>
      <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5"  v-show="!remove" @click="remove = true"
        >Eliminar programa</v-btn
      >
      <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5"  v-show="remove" @click="remove = false"
        >Completar borrado</v-btn
      >
      <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5"  v-show="remove" @click="remove = false"
        >Cancelar</v-btn
      >
    </div>
    <div class="listado">
      <custom-table
        :remove="remove"
        :label="{
          Id: 'id',
          Nombre: 'nombre',
          Sectores: 'sectores',
          Inicio: 'horaInicio',
          Dias: 'dias',
        }"
        :pageSize="5"
        countVuex="numProgramas"
        infoVuex="programas"
      >
      </custom-table>
    </div>
  </div>
</template>

<script>
import headerCustom from "@/components/Header";
import customTable from "@/components/CustomTable";

export default {
  components: {
    headerCustom,
    customTable,
  },
  data() {
    return {
      remove: false,
    };
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
