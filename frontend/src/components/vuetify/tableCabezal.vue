<template>
  <div class="tableCabezal mb-5">
    <v-data-table
      :headers="headers"
      :items="cabezales"
      sort-by="calories"
      class="elevation-1"
      hide-default-footer
      :items-per-page="15"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title v-show="windowWidth > 500"
            >Listado de cabezales</v-toolbar-title
          >
          <v-divider
            v-show="windowWidth > 500"
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>
          <v-dialog
            transition="dialog-bottom-transition"
            v-model="dialog"
            max-width="500px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-btn
                id="newCabezalBtnId"
                color="primary"
                dark
                class="mb-2"
                v-bind="attrs"
                v-on="on"
              >
                Nuevo cabezal
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="headline">{{ formTitle }}</span>
              </v-card-title>

              <v-card-text>
                <v-container>
                  <v-row>
                    <v-col>
                      <v-text-field
                        v-model="editedItem.name"
                        label="Nombre"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card-text>

              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="close">
                  Cancelar
                </v-btn>
                <v-btn color="blue darken-1" text @click="save">
                  Guardar
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog
            transition="dialog-bottom-transition"
            v-model="dialogDelete"
            max-width="500px"
          >
            <v-card>
              <v-card-title class="headline">Estas seguro?</v-card-title>
              <v-card-text
                ><b
                  >Estas seguro que quieres eliminar este cabezal?</b
                ></v-card-text
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
        <v-btn id="AccederBtnId" @click="programList(item)">Acceder</v-btn>
      </template>
      <template v-slot:item.actions="{ item }">
        <div v-if="!customAction">
          <v-btn elevation="2" icon
            ><font-awesome-icon
              id="EditarBtnId"
              class="btn"
              @click="editItem(item)"
              icon="edit"
          /></v-btn>
          <v-btn elevation="2" icon>
            <font-awesome-icon
              id="EliminarBtnId"
              class="btn"
              @click="deleteItem(item)"
              icon="trash-alt"
            />
          </v-btn>
        </div>
        <slot v-else></slot>
      </template>
      <template v-slot:no-data>
        <v-btn class="btn" color="primary" @click="initialize">
          Recargar
        </v-btn>
      </template>
    </v-data-table>
    <div class="text-center pt-2">
      <v-pagination v-model="page" :length="pageCount"></v-pagination>
    </div>

    <v-tour name="cabezales" :steps="steps" :options="myOptions"></v-tour>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data: () => ({
    page: 1,
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
      { text: "Última actualización", sortable: false, value: "updated_at" },
      { text: "Acceder", value: "acceder", sortable: false },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    editedIndex: -1,
    editedItem: {
      name: "",
    },
    defaultItem: {
      name: "",
    },
    myOptions: {
      useKeyboardNavigation: true,
      labels: {
        buttonSkip: "Saltar tour",
        buttonPrevious: "Anterior",
        buttonNext: "Siguiente",
        buttonStop: "Finalizar",
      },
    },
    steps: [
      {
        target: "#newCabezalBtnId",
        header: {
          title: "Creación de un nuevo cabezal",
        },
        content:
          "Permite crear un cabezal nuevo, únicamente con el nombre de este",
      },
      {
        target: "#AccederBtnId",
        header: {
          title: "Acceder al cabezal",
        },
        content: "Siempre puedes escoger un cabezal para acceder a el",
      },
      {
        target: "#EditarBtnId",
        header: {
          title: "Editar el cabezal",
        },
        content: "Permite editar el nombre del cabezal seleccionado",
      },
      {
        target: "#EliminarBtnId",
        header: {
          title: "Eliminar el cabezal",
        },
        content: "Permite eliminar el cabezal seleccionado",
      },
    ],
  }),
  props: {
    hideHeader: Boolean,
    customAction: Boolean,
  },

  computed: {
    ...mapGetters(["cabezales", "numCabezales", "windowWidth"]),
    ...mapGetters({
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
    page(val, old) {
      if (val != old && val <= this.pageCount && val >= 1)
        this.getCabezales(this.page);
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    ...mapActions([
      "getCabezales",
      "newCabezales",
      "updateHead",
      "deleteHead",
      "setSelectedHead",
    ]),
    initialize() {
      this.getCabezales();
    },

    editItem(item) {
      this.editedIndex = this.cabezales.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.cabezales.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.deleteHead(this.cabezales[this.editedIndex]);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    save() {
      if (this.editedIndex > -1) {
        this.updateHead(this.editedItem);
      } else {
        // this.cabezales.push(this.editedItem);
        this.newCabezales(this.editedItem);
      }
      this.close();
    },
    programList(item) {
      this.setSelectedHead(item);
      this.$router.push("Programas");
    },
  },
};
</script>
<style>
.btn {
  cursor: pointer;
}

.tableCabezal {
  width: 100%;
}

th {
  height: 0px;
}
</style>
