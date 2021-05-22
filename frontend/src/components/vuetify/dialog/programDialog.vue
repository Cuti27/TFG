<template>
  <v-dialog
    v-model="dialog"
    transition="dialog-bottom-transition"
    max-width="90%"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
      class="mt-5"
        color="primary"
        elevation="5"
        outlined
        rounded
        :fab="!show"
        :small="!show"
        v-bind="attrs"
        v-on="on"
        ><div v-if="show">Escoger programa <font-awesome-icon icon="plus-circle" /></div>
        <font-awesome-icon v-else icon="plus-circle" />
      </v-btn>
    </template>
    <template v-slot:default="dialog">
      <v-card>
        <!-- <v-toolbar color="primary" dark
          ><h2>Escoge el programa</h2></v-toolbar
        > -->
        <v-card-title class="headline primary lighten-1">Escoge el programa</v-card-title>
        <v-divider></v-divider>
        <v-container class="pa-4">
          <custom-table
            :remove="true"
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
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog.value = false">
            Cancelar
          </v-btn>

          <v-btn
            color="blue darken-1"
            text
            @click="
              dialog.value = false;
              submit();"
          >
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog>
</template>

<script>
import customTable from "@/components/CustomTable";
export default {
  components: {
    customTable,
  },
  data() {
    return {
      dialog: false,
    };
  },
  props: {
      show: Boolean,
  }
};
</script>

<style>
</style>