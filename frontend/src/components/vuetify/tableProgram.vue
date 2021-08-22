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
    <div v-if="!hideHeader" class="header">
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
            id="newProgramBtnId"
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
                    v-if="checkProgram"
                    v-model="nameProgram"
                    label="Nombre"
                  ></v-text-field>
                  <b v-else>
                  En este cabezal no hay suficientes emisores o sectores,
                  asegurate de que al menos tenga un emisor y un sector
                </b>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="close"> Cancelar </v-btn>
            <v-btn v-if="nameProgram" color="blue darken-1" text @click="save">
              Acceder
            </v-btn>
            <v-btn v-else-if="checkProgram" disabled color="blue darken-1" text> Acceder </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-btn
        id="dispositivosBtnId"
        color="primary"
        dark
        class="mx-1 my-2 wrap"
        @click="nuevoDispositivo"
      >
        Listados de dispositivos
      </v-btn>
    </div>

    <v-data-table
      :headers="headers"
      :items="filterProgram"
      sort-by="calories"
      class="elevation-1"
      hide-default-footer
      :items-per-page="15"
      dense
      mobile-breakpoint="860"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title v-if="!hideHeader" v-show="windowWidth > 500"
            >Listado de programas</v-toolbar-title
          >
          <v-divider
            v-if="!hideHeader"
            v-show="windowWidth > 500"
            class="mx-4"
            inset
            vertical
          ></v-divider>
          <v-spacer></v-spacer>

          <v-dialog
            transition="dialog-bottom-transition"
            v-model="dialogDelete"
            max-width="500px"
          >
            <v-card>
              <v-card-title class="headline">Estas seguro?</v-card-title>
              <v-card-text>
                <b>
                  Estas seguro que quieres eliminar este programa?
                </b>
                
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete"
                  >Cancelar</v-btn
                >
                <v-btn
                  color="blue darken-1"
                  text
                  @click="deleteItemConfirm"
                  >Aceptar</v-btn
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
      <template v-slot:item.emitter="{ item }">
        <span v-for="emisor in item.emitter" :key="'emisor' + emisor.id"
          >- {{ emisor.name }}<br
        /></span>
      </template>
      <template v-slot:item.activate="{ item }">
        <v-switch
          id="activadoSwitchId"
          inset
          v-model="item.active"
          @change="activateDialog(item)"
        ></v-switch>
      </template>
      <template v-slot:item.actions="{ item }">
        <div v-if="!customAction">
          <v-btn elevation="2" icon
            ><font-awesome-icon id="EditarBtnId" class="btn" @click="editItem(item)" icon="edit"
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
    <v-dialog v-model="dialogChange" width="500">
      <v-card>
        <v-card-title class="text-h5 grey lighten-2"> Seguro? </v-card-title>
        <v-card-text>
          Estas seguro de querer desactivar el programa?
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="secondary" text @click="changeToggle(false)">
            Cancelar
          </v-btn>
          <v-btn color="primary" text @click="changeToggle(true)">
            Aceptar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-tour name="programas" :steps="steps" :options="myOptions"></v-tour>
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
    dialogChange: false,
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
      { text: "Emisores", value: "emitter", sortable: false },
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
    itemChange: {},
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
        target: "#newProgramBtnId",
        header: {
          title: "Creación de un nuevo programa",
        },
        content:
          "Permite crear un cabezal nuevo, indicando inicialmente el nombre, y posteriormente rellenando todo el formulario",
      },
      {
        target: "#dispositivosBtnId",
        header: {
          title: "Listado de dispositivos",
        },
        content:
          "Permite acceder al listado de dispositivos del cabezal, o registrar un nuevo cabezal",
      },
      {
        target: "#activadoSwitchId",
        header: {
          title: "Activar/Desactivar programa",
        },
        content:
          "Permite activar o desactivar un programa, sin necesidad de acceder a la información del mismo",
      },
       {
        target: "#EditarBtnId",
        header: {
          title: "Editar el programa actual",
        },
        content: "Poniendo en primer lugar el nombre y despues modificando lo que se quiera en el formulario",
      },
      {
        target: "#EliminarBtnId",
        header: {
          title: "Eliminar el programa",
        },
        content: "Permite eliminar el programa seleccionado",
      },
    ],
  }),
  props: {
    hideHeader: Boolean,
    customAction: Boolean,
    removeActivate: Boolean,
    remove: [String,Number],
  },

  computed: {
    ...mapGetters([
      "programas",
      "numProgramas",
      "windowWidth",
      "emitter",
      "sectors",
    ]),
    ...mapGetters({
      pageCount: "last_page",
    }),
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo programa" : "Editar el programa";
    },
    checkProgram(){
      return this.emitter.length != 0 && this.sectors.length != 0
    },
    filterProgram(){
      if(this.remove){
        let removeIndex = this.programas.map((item) => { return item.id; }).indexOf(this.remove);
        const filtredProgram = [...this.programas]
        filtredProgram.splice(removeIndex, 1);
        return filtredProgram;
      }
      return this.programas
    }
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
    if(!this.removeActivate) 
      this.headers.push( { text: "Activado", value: "activate", sortable: false });
  },
  beforeMount(){
    this.loadEmitterSector()
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
      "changeProgram",
      "setTempProgram"
    ]),
    activateDialog(item) {
      this.dialogChange = true;
      this.itemChange = item;
    },
    changeToggle(val) {
      this.dialogChange = false;

      if (val) {
        this.changeProgram(this.itemChange);
      } else {
        this.programas.every((programa) => {
          if (programa.id == this.itemChange.id) {
            programa.active = !programa.active;
            return false;
          }
          return true;
        });
      }
    },
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
      console.log("Set");
      console.log(this.editedItem);
      this.setTempProgram(this.editedItem);
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

.v-data-table > .v-data-table__wrapper .v-data-table__mobile-table-row {
  margin: 10px; // add margin between each row
  border: 1px solid #ededed; // add border color
  display: block; // display table row as block
}
</style>
