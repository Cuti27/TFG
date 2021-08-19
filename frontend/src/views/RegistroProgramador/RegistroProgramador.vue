<template>
  <div class="registroProgramador">
    <!-- Header -->
    <header-custom
      :tour="showInputOutput ? 'registro' : 'listado'"
      name="Registro de programador de riego"
    ></header-custom>

    <!-- Identificador -->
    <div v-if="!showInputOutput" class="identificador">
      <h3>Seleccione el tipo de dispositivo</h3>
      <hr />
      <div class="identificadorBody">
        <form>
          <!-- Selector de dispositivo -->
          <custom-select
            id="selectTypeProgramDevice"
            button
            class="mt-3"
            @change="update($event)"
            :selected="tipoProgramador"
            :values="listaTipos"
          ></custom-select>
          <div v-if="tipoProgramador == 2" id="passwordIdField">
            <v-text-field label="Usuario" class="mt-3"></v-text-field>
            <v-text-field
              label="Contraseña"
              class="mt-3"
              type="password"
            ></v-text-field>
            <v-btn>Logear</v-btn>
          </div>
          <div v-else class="id mt-3" id="passwordIdField">
            <v-text-field v-model="nombre" label="Nombre"></v-text-field>
            <v-text-field
              v-model="id"
              label="Identificador generado"
            ></v-text-field>
            <v-btn id="checkConnectionBtn" @click="createDevice()" class="mt-3">
              Comprobar conexión
            </v-btn>

            <v-row justify="center">
              <v-dialog
                transition="dialog-bottom-transition"
                v-model="dialog"
                scrollable
                max-width="500px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-btn id="listadoBtn" class="mt-5" v-bind="attrs" v-on="on">
                    Listado de dispositivos
                  </v-btn>
                </template>
                <v-card>
                  <v-card-title>Listado de dispositivos</v-card-title>
                  <v-divider></v-divider>
                  <v-card-text style="height: 300px">
                    <v-radio-group v-model="radioGroup" column>
                      <v-radio
                        v-for="device in allDevice"
                        :key="device.id"
                        :label="device.name"
                        :value="device.id"
                      ></v-radio>
                    </v-radio-group>
                  </v-card-text>
                  <v-divider></v-divider>
                  <v-card-actions>
                    <v-btn
                      color="red darken-1"
                      text
                      @click="changeDialog"
                      :disabled="radioGroupCheck"
                    >
                      Borrar
                    </v-btn>

                    <!-- TODO: Hacer el borrado con una ventana nueva -->
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">
                      Cancelar
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="selected()">
                      Seleccionar
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
              <v-dialog
                transition="dialog-bottom-transition"
                :value="dialogCheck"
                max-width="500px"
              >
                <v-card>
                  <v-card-title>
                    <span>Seguro que quiere borrar el dispositivo?</span>
                    <v-spacer></v-spacer>
                  </v-card-title>
                  <v-card-text>
                    Esto borrará todos los programas de riego a los que esta
                    enlazado este dispositivo
                  </v-card-text>
                  <v-card-actions class="justify-end">
                    <v-btn color="secondary" text @click="changeDialog">
                      Cancelar
                    </v-btn>
                    <v-btn
                      color="primary"
                      outlined
                      depressed
                      text
                      @click="remove"
                    >
                      Aceptar
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-row>
          </div>
        </form>
      </div>

      <v-tour name="listado" :steps="steps" :options="myOptions"></v-tour>
    </div>

    <!-- Imagen del dispositivo -->
    <div v-else class="device">
      <perfil-programador
        id="infoProgramador"
        :img="image.src"
        :type="listaTipos[tipoProgramador]"
        :name="nombre"
        :idDevice="id"
        :headName="selectedHead.name"
        :headId="selectedHead.id"
        :date="selectedHead.updated_at"
      />
    </div>

    <div v-if="showInputOutput" class="InputOutput">
      <div class="salidasDigitales">
        <output-input
          id="digitalOutput"
          title="Salidas Digitales"
          type="Salida Digital"
          :options="digitalOutput"
          vuexSelect="digitalOutput"
          @update="createDigitalOutput"
          nombre
        ></output-input>
      </div>
      <div class="entradasDigitales">
        <output-input
          id="digitalInput"
          title="Entradas Digitales"
          type="Entradas Digital"
          :options="digitalInput"
          vuexSelect="digitalInput"
          @update="createDigitalInput"
        ></output-input>
      </div>
      <div class="salidasAnalogicas">
        <output-input
          id="analogicalOutput"
          title="Salidas Analógicas"
          type="Salida Analógicas"
          :options="analogicalOutput"
          vuexSelect="analogicalOutput"
          @update="createAnalogicalOutput"
        ></output-input>
      </div>
      <div class="entradasAnalogicas">
        <output-input
          id="analogicalInput"
          title="Entradas Analógicas"
          type="Entradas Analógicas"
          :options="analogicalInput"
          vuexSelect="analogicalInput"
          @update="createAnalogicalInput"
        ></output-input>
      </div>
    </div>
    <div class="retroceder mt-5">
      <submit-button id="retrocederBtn" @click="resetPage()">Retroceder</submit-button>
    </div>
    <v-tour name="registro" :steps="steps2" :options="myOptions"></v-tour>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

import headerCustom from "@/components/Header";
import customSelect from "@/components/Select";
import outputInput from "@/views/RegistroProgramador/components/outputInput";
import perfilProgramador from "@/views/RegistroProgramador/components/perfilProgramador";
import SubmitButton from "@/components/SubmitButton";

// Imagenes necesarias
import imageEsp32 from "@/assets/esp32.png";
import imageReleLogo from "@/assets/releLogo.png";
import imageAgronic from "@/assets/Agronic.png";

export default {
  components: {
    headerCustom,
    customSelect,
    outputInput,
    perfilProgramador,
    SubmitButton,
  },
  data() {
    return {
      dialog: false,
      dialogDelete: false,
      radioGroup: "",
      nombre: "",
      id: "",
      tipoProgramador: 0,

      // Imagenes de los distintos programadores
      imagenes: [
        {
          id: 0,
          src: imageEsp32,
          alt: "Imagen donde se puede ver el esp32",
        },
        {
          id: 1,
          src: imageReleLogo,
          alt: "Imagen donde se puede ver el relé de siemens",
        },
        {
          id: 2,
          src: imageAgronic,
          alt: "Imagen donde se puede ver el programador de Agronic",
        },
      ],
      image: {},
      entradasDigitales: [
        {
          tipo: "x",
          descripcion: "",
        },
      ],
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
          target: "#selectTypeProgramDevice",
          header: {
            title: "Seleccionar el tipo de selector",
          },
          content:
            "Nos permite seleccionar el tipo de dispositivo que queremos configurar",
        },
        {
          target: "#passwordIdField",
          header: {
            title: "Contraseña o id",
          },
          content:
            "Una vez seleccionado el tipo de dispositivo, debemos enlazarlo, en el caso de ser agronic con su contraseña, y en caso contrario con el id con el que lo hemos configurado",
        },
        {
          target: "#registroIdBtn",
          header: {
            title: "Boton de registro de Id",
          },
          content:
            "La generación de id esta siempre disponible, un id esta activo durante un tiempo fijo, con su posterior destrucción si no se ha utilizado, tiene un máximo de 10 y servirá para poder conectarse al dispositivo deseado",
        },
        {
          target: "#checkConnectionBtn",
          header: {
            title: "Comprobar conexión",
          },
          content:
            "Una vez insertados en los campos anteriores el nombre y contraseña o identificador, nos conectaremos a el para configurar en la app la configuración realizada en el dispositivo",
        },
        {
          target: "#listadoBtn",
          header: {
            title: "Listado de dispositivos",
          },
          content:
            "Podemos ver los dispositivos conectados para reconfigurarlos, e incluso eliminarlos. (Aviso: para borrar un dispositivo no se debe encontrar en ningún programa)",
        },
      ],
      steps2: [
        {
          target: `#infoProgramador`,
          header: {
            title: "Información programador",
          },
          content:
            "Información relacionado con el programador actual",
        },
        {
          target: `#digitalOutput`,
          header: {
            title: "Salidas digitales",
          },
          content:
            "Panel para configurar las salidas digitales del dispositivo",
        },
        {
          target: `#digitalInput`,
          header: {
            title: "Entradas digitales",
          },
          content:
            "Panel para configurar las entradas digitales del dispositivo",
        },
        {
          target: `#analogicalOutput`,
          header: {
            title: "Salidas digitales",
          },
          content:
            "Panel para configurar las salidas analógicas del dispositivo",
        },
        {
          target: `#analogicalInput`,
          header: {
            title: "Entradas digitales",
          },
          content:
            "Panel para configurar las entradas analógicas del dispositivo",
        },
        {
          target: `#retrocederBtn`,
          header: {
            title: "Retroceder",
          },
          content:
            "Permite volver a la ventana anterior",
        },
      ],
    };
  },
  computed: {
    ...mapGetters([
      "digitalInput",
      "digitalOutput",
      "analogicalInput",
      "analogicalOutput",
      "typeDevice",
      "configureDevice",
      "allDevice",
      "selectedHead",
      "configureDeviceOutputInput",
    ]),
    listaTipos() {
      return this.typeDevice.map((element) => element.type);
    },
    showInputOutput() {
      return this.configureDevice;
    },
    dialogCheck() {
      return this.dialogDelete && this.radioGroup;
    },
    radioGroupCheck() {
      return this.radioGroup == "";
    },
  },
  beforeMount() {
    this.image = this.imagenes[this.tipoProgramador];
    this.getAllDevice();
  },
  methods: {
    ...mapActions([
      "actionCreateDevice",
      "getAllDevice",
      "getAllInfoDevice",
      "createDigitalOutput",
      "createDigitalInput",
      "createAnalogicalOutput",
      "createAnalogicalInput",
      "deleteDevice",
      "resetConfigureDevice",
    ]),
    resetPage() {
      if (!this.configureDevice || this.configureDevice == {})
        this.$router.push("Cabezales");
      else this.resetConfigureDevice();
    },
    remove() {
      this.deleteDevice(this.radioGroup);
      this.changeDialog();
    },
    changeDialog() {
      if (this.radioGroup) {
        this.dialogDelete = !this.dialogDelete;
      }
    },
    update(event) {
      this.tipoProgramador = event;
      this.image = this.imagenes[this.tipoProgramador];
    },
    createDevice() {
      // TODO: añadir Agronic
      let object = {
        name: this.nombre,
        type: this.tipoProgramador + 1,
        id: this.id,
      };

      this.actionCreateDevice(object);
    },
    async selected() {
      this.dialog = false;
      if (this.radioGroup != "") {
        await this.getAllInfoDevice({ id: this.radioGroup });
        this.nombre = this.configureDevice.name;
        this.id = this.configureDevice.id;
        this.tipoProgramador = this.configureDevice.type - 1;
        this.image = this.imagenes[this.tipoProgramador];
      }
    },
    updateOutputInput(data) {
      console.log(data);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";
.registroProgramador {
  display: grid;
  grid-template-columns: auto;
  grid-template-rows: auto;
  grid-template-areas:
    "head"
    "device"
    "inputOutput";

  .identificador,
  .salidasDigitales,
  .entradasDigitales,
  .salidasAnalogicas,
  .entradasAnalogicas,
  .retroceder {
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
    border-radius: 25px;
    margin: 10px;
    padding: 10px 15px;
    background: $white;
  }

  .header {
    grid-area: head;
  }

  .identificador {
    height: 100%;
    .identificadorBody {
      grid-area: id;
      display: flex;
      align-items: center;

      justify-content: flex-start;
      flex-direction: column;

      form {
        width: 80%;
      }
    }
  }

  .device {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .InputOutput {
    grid-area: inputOutput;
  }
}
</style>
