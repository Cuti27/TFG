<template>
  <div>
    <v-data-table
      :headers="headers"
      :items="cabezales"
      sort-by="calories"
      class="elevation-1"
      hide-default-footer
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>Listado de programas</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-btn
            @click="loadEmitterSector()"
            color="primary"
            dark
            class="mb-2 mr-2"
          >
            Nuevo programa
          </v-btn>

          <v-btn color="primary" dark class="mb-2 mr-2">
            Nuevo dispositivo
          </v-btn>

          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="headline"
                >Estas seguro que quieres eliminar este programa?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancelar</v-btn
                >
                <v-btn color="blue darken-1" text @click="deleteItemConfirm"
                  >Si</v-btn
                >
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.acceder="{ item }">
        <v-btn @click="programList(item)">Acceder</v-btn>
      </template>
      <template v-slot:item.actions="{ item }">
        <font-awesome-icon class="mr-2" @click="editItem(item)" icon="edit" />
        <font-awesome-icon @click="deleteItem(item)" icon="trash-alt" />
      </template>
      <template v-slot:no-data>
        <v-btn color="primary" @click="initialize"> Recargar </v-btn>
      </template>
    </v-data-table>
    <div class="text-center pt-2">
      <v-pagination
        :value="page"
        @next="nextPage()"
        @previous="previousPage()"
        :length="pageCount"
      ></v-pagination>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data: () => ({
    // page: 1,
    // pageCount: 1,
    dialog: false,
    dialogDelete: false,
    pagination: {
      rowsPerPage: 15,
    },
    headers: [
      {
        text: "Identificador",
        sortable: false,
        value: "id",
      },
      { text: "Nombre", sortable: false, value: "name" },
      { text: "Hora inicio", sortable: false, value: "time" },
      { text: "Sectores", value: "sector", sortable: false },
      { text: "Dias", value: "week", sortable: false },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    editedIndex: -1,
    editedItem: {
      name: "",
    },
    defaultItem: {
      name: "",
    },
  }),

  computed: {
    ...mapGetters(["programas", "numProgramas"]),
    ...mapGetters({
      page: "current_page",
      pageCount: "last_page",
    }),
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo cabezal" : "Editar el cabezal";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    ...mapActions([
      "listProgram",
      "newCabezales",
      "updateHead",
      "deleteHead",
      "setSelectedHead",
      "getEmitterHead",
      "getSectorHead",
    ]),
    initialize() {
      this.listProgram();
    },

    editItem(/**item */) {
      // this.editedIndex = this.cabezales.indexOf(item);
      // this.editedItem = Object.assign({}, item);
      // this.dialog = true;
    },

    deleteItem(/**item */) {
      // this.editedIndex = this.cabezales.indexOf(item);
      // this.editedItem = Object.assign({}, item);
      // this.dialogDelete = true;
    },

    deleteItemConfirm() {
      // this.deleteHead(this.cabezales[this.editedIndex]);
      // this.closeDelete();
    },

    close() {
      // this.dialog = false;
      // this.$nextTick(() => {
      //   this.editedItem = Object.assign({}, this.defaultItem);
      //   this.editedIndex = -1;
      // });
    },

    closeDelete() {
      // this.dialogDelete = false;
      // this.$nextTick(() => {
      //   this.editedItem = Object.assign({}, this.defaultItem);
      //   this.editedIndex = -1;
      // });
    },
    nextPage() {
      if (this.page < this.pageCount) this.listProgram(this.page + 1);
    },
    previousPage() {
      if (this.page > 1) this.listProgram(this.page - 1);
    },
    save() {
      // if (this.editedIndex > -1) {
      //   this.updateHead(this.editedItem);
      // } else {
      //   // this.cabezales.push(this.editedItem);
      //   this.newCabezales(this.editedItem);
      // }
      // this.close();
    },
    programList(item) {
      this.setSelectedHead(item);
    },
    loadEmitterSector() {
      this.getSectorHead();
      this.getEmitterHead();
    },
  },
};
</script>
<style></style>
