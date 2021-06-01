<template>
  <div class="registroProgramador">
    <!-- Header -->
    <header-custom name="Registro de programador de riego"></header-custom>

    <!-- Identificador -->
    <div v-if="!showInputOutput" class="identificador">
      <h3>Seleccione el tipo de dispositivo</h3>
      <hr />
      <div class="identificadorBody">
        <form>
          <!-- Selector de dispositivo -->
          <custom-select
            button
            class="mt-3"
            @change="update($event)"
            :selected="tipoProgramador"
            :values="listaTipos"
          ></custom-select>
          <div v-if="tipoProgramador == 2">
            <v-text-field label="Usuario" class="mt-3"></v-text-field>
            <v-text-field
              label="Contraseña"
              class="mt-3"
              type="password"
            ></v-text-field>
            <v-btn>Logear</v-btn>
          </div>
          <div v-else class="id mt-3">
            <v-text-field v-model="nombre" label="Nombre"></v-text-field>
            <v-text-field
              v-model="id"
              label="Identificador generado"
            ></v-text-field>
            <v-btn @click="createDevice()" class="mt-3"
              >Comprobar conexión</v-btn
            >

            <v-row justify="center">
              <v-dialog v-model="dialog" scrollable max-width="500px">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn class="mt-5" v-bind="attrs" v-on="on">
                    Cargar dispositivo
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
                    <v-btn color="blue darken-1" text @click="dialog = false">
                      Cancelar
                    </v-btn>
                    <v-btn color="blue darken-1" text @click="selected()">
                      Seleccionar
                    </v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-row>
          </div>
        </form>
      </div>
    </div>

    <!-- Imagen del dispositivo -->
    <div v-else class="device">
      <img :key="image.key" :src="image.src" :alt="image.alt" />
      <div class="infoDevice mx-5">
        <v-text-field
          disabled
          v-model="listaTipos[tipoProgramador]"
          label="Tipo de programador"
        ></v-text-field>
        <v-text-field disabled v-model="nombre" label="Nombre"></v-text-field>
        <v-text-field
          disabled
          v-model="id"
          label="Identificador generado"
        ></v-text-field>
      </div>
      <div class="infoHead mx-5">
        <v-text-field
          disabled
          v-model="selectedHead.id"
          label="Id Cabezal"
        ></v-text-field>
        <v-text-field
          disabled
          v-model="selectedHead.name"
          label="Nombre Cabezal"
        ></v-text-field>
        <v-text-field
          disabled
          v-model="selectedHead.updated_at"
          label="Actualizado Cabezal"
        ></v-text-field>
      </div>
    </div>
    <div v-if="showInputOutput" class="InputOutput">
      <div class="salidasDigitales">
        <output-input
          title="Salidas Digitales"
          type="Salida Digital"
          :options="digitalOutput"
          vuexSelect="digitalOutput"
          @update="createDigitalOutput"
        ></output-input>
      </div>
      <div class="entradasDigitales">
        <output-input
          title="Entradas Digitales"
          type="Entradas Digital"
          :options="digitalInput"
          vuexSelect="digitalInput"
          @update="createDigitalInput"
        ></output-input>
      </div>
      <div class="salidasAnalogicas">
        <output-input
          title="Salidas Analógicas"
          type="Salida Analógicas"
          :options="analogicalOutput"
          vuexSelect="analogicalOutput"
          @update="createAnalogicalOutput"
        ></output-input>
      </div>
      <div class="entradasAnalogicas">
        <output-input
          title="Entradas Analógicas"
          type="Entradas Analógicas"
          :options="analogicalInput"
          vuexSelect="analogicalInput"
          @update="createAnalogicalInput"
        ></output-input>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

import headerCustom from "@/components/Header";
import customSelect from "@/components/Select";
import outputInput from "@/views/RegistroProgramador/components/outputInput";

// Imagenes necesarias
import imageEsp32 from "@/assets/esp32.png";
import imageReleLogo from "@/assets/releLogo.png";
import imageAgronic from "@/assets/Agronic.png";

export default {
  components: {
    headerCustom,
    customSelect,
    outputInput,
  },
  data() {
    return {
      dialog: false,
      radioGroup: 1,
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
    ]),
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
      if (this.radioGroup != 1) {
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
    "head head"
    "device device"
    "inputOutput inputOutput";

  .identificador,
  .device,
  .salidasDigitales,
  .entradasDigitales,
  .salidasAnalogicas,
  .entradasAnalogicas {
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
    width: 85vw;
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
    grid-area: device;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    align-items: center;
    padding: 0px;
    img {
      max-width: 33vw;
      height: 33vh;
    }

    .infoDevice,
    .infoHead {
      min-width: 400px;
    }
  }

  .InputOutput {
    grid-area: inputOutput;
  }

  // .salidasDigitales {
  //   grid-area: salidasDigitales;
  // }

  // .entradasDigitales {
  //   grid-area: entradasDigitales;
  // }

  // .salidasAnalogicas {
  //   grid-area: salidasAnalogicas;
  // }

  // .entradasAnalogicas {
  //   grid-area: entradasAnalogicas;
  // }
}
</style>
