<template>
  <div class="mb-5">
    <v-alert
      class="onTop"
      v-if="error"
      dismissible
      border="left"
      color="red"
      type="error"
      transition="scale-transition"
      @input="error = ''"
      >{{ error }}</v-alert
    >
    <div class="header">
      <v-dialog
        transition="dialog-bottom-transition"
        v-model="dialog"
        max-width="500px"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn
            @click="loadEmitterSector()"
            color="primary"
            dark
            class="my-2"
            v-bind="attrs"
            v-on="on"
          >
            Nuevo programa
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
                    v-model="nameProgram"
                    label="Nombre"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close"> Cancelar </v-btn>
            <v-btn v-if="nameProgram" color="blue darken-1" text @click="save"> Acceder </v-btn>
            <v-btn v-else disabled color="blue darken-1" text > Acceder </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-btn color="primary" dark class="mx-1 my-2 wrap" @click="nuevoDispositivo">
        Listados de dispositivos
      </v-btn>
    </div>

    <v-data-table
      :headers="headers"
      :items="programas"
      sort-by="calories"
      class="elevation-1"
      hide-default-footer
      :items-per-page="15"
      dense
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title  v-show="windowWidth > 500">Listado de programas</v-toolbar-title>
          <v-divider  v-show="windowWidth > 500" class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>

          <v-dialog
            transition="dialog-bottom-transition"
            v-model="dialogDelete"
            max-width="500px"
          >
            <v-card>
              <v-card-title class="headline">Estas seguro?</v-card-title>
              <v-card-text
                ><b
                  >Estas seguro que quieres eliminar este programa?</b
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
      <template v-slot:item.programDay="{ item }">
        <day-selector disable xs :dias="item.programDay"></day-selector>
      </template>
      <template v-slot:item.time="{ item }">
        <span v-for="time in item.timer" :key="'timer' + time.id"
          >{{ time.timeStart }}<br
        /></span>
      </template>
      <template v-slot:item.sector="{ item }">
        <span v-for="sector in item.sector" :key="'sector' + sector.id"
          >- {{ sector.name }}<br
        /></span>
      </template>
      <template v-slot:item.actions="{ item }">
        <font-awesome-icon
          class="btn mr-2"
          @click="editItem(item)"
          icon="edit"
        />
        <font-awesome-icon
          class="btn"
          @click="deleteItem(item)"
          icon="trash-alt"
        />
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
import daySelector from "@/components/DaySelector";

export default {
  components: { daySelector },
  data: () => ({
    page: 1,
    // pageCount: 1,
    nameProgram: "",
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
      { text: "Dias", value: "programDay", align: "center", sortable: false },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    editedIndex: -1,
    editedItem: {
      name: "",
    },
    defaultItem: {
      name: "",
    },
    error: "",
  }),

  computed: {
    ...mapGetters(["programas", "numProgramas", "windowWidth"]),
    ...mapGetters({
      pageCount: "last_page",
    }),
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo programa" : "Editar el programa";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
    page(val, old){
      if(val != old &&  val <= this.pageCount && val >= 1) this.getCabezales(this.page);
    }
  },

  created() {
    this.initialize();
  },

  methods: {
    ...mapActions([
      "listProgram",
      "deleteProgram",
      "setSelectedHead",
      "getEmitterHead",
      "getSectorHead",
      "loadProgramName",
      "loadUpdateName",
      "resetConfigureDevice",
    ]),
    initialize() {
      this.listProgram();
    },

    editItem(item) {
      console.log(item);
      this.editedIndex = this.programas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.nameProgram = this.editedItem.name;
      this.dialog = true;
    },

    deleteItem(item) {
      this.editedIndex = this.programas.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.deleteProgram(this.programas[this.editedIndex]);
      this.closeDelete();
    },

    close() {
      this.dialog = false;
    },

    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    nextPage() {
      if (this.page < this.pageCount) this.listProgram(this.page + 1);
    },
    previousPage() {
      if (this.page > 1) this.listProgram(this.page - 1);
    },
    save() {
      if (this.nameProgram != "") {
        if (this.editedIndex !== -1) {
          if (this.nameProgram != this.editedItem.name)
            this.loadUpdateName(true);
        }
        this.loadProgramName(this.nameProgram);
        this.nameProgram = "";
      } else {
        this.error = "Debe especificar un nombre";
      }
      this.close();
      this.$router.push("programs");
    },
    programList(item) {
      this.setSelectedHead(item);
    },
    loadEmitterSector() {
      this.getSectorHead();
      this.getEmitterHead();
    },
    nuevoDispositivo() {
      this.resetConfigureDevice();
      this.$router.push("registrarProgramador");
    },
  },
};
</script>
<style lang="scss" scoped>
@import "src/css/colorSchema.scss";
.onTop {
  position: fixed;
  z-index: 9950;
  top: 10px;
}

.header {
  box-shadow: 5px 5px 15px $primaryDark, -5px -5px 15px #ffffff;
  border-radius: 5px;
  margin: 0 auto;
  margin-bottom: 10px;
  padding: 10px 15px;
  background: $white;
  width: 100%;

  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
}

.btn {
  cursor: pointer;
}

.wrap {
  white-space: normal;
}
</style>
