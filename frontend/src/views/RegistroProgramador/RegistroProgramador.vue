<template>
  <div class="registroProgramador">
    <!-- Header -->
    <header-custom name="Registro de programador de riego"></header-custom>

    <!-- Identificador -->
    <div class="identificador">
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
            :values="listaProgramadores"
          ></custom-select>
          <div v-if="tipoProgramador == 2">
            <custom-input
              class="mt-3"
              type="text"
              placeholder="Usuario agronic"
            ></custom-input>
            <custom-input
              class="mt-3"
              type="password"
              placeholder="Contraseña agronic"
            ></custom-input>
            <login-button>Logear</login-button>
          </div>
          <div v-else class="id mt-3">
            <v-text-field label="Identificador generado"></v-text-field>
            <v-btn class="mt-3">Comprobar conexión</v-btn>
          </div>
        </form>
      </div>
    </div>

    <!-- Imagen del dispositivo -->
    <div class="device">
      <img :key="image.key" :src="image.src" :alt="image.alt" />
    </div>

    <div class="salidasDigitales">
      <output-input
        title="Salidas Digitales"
        type="Salida Digital"
        :options="digitalOutput"
      ></output-input>
    </div>
    <div class="entradasDigitales">
      <output-input
        title="Entradas Digitales"
        type="Entradas Digital"
        :options="digitalInput"
      ></output-input>
    </div>
    <div class="salidasAnalogicas">
      <output-input
        title="Salidas Analógicas"
        type="Salida Analógicas"
        :options="analogicalOutput"
      ></output-input>
    </div>
    <div class="entradasAnalogicas">
      <output-input
        title="Entradas Analógicas"
        type="Entradas Analógicas"
        :options="analogicalInput"
      ></output-input>
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import headerCustom from "@/components/Header";
import customInput from "@/components/CustomInput";
import customSelect from "@/components/Select";
import loginButton from "@/components/LoginButton";
import outputInput from "@/views/RegistroProgramador/components/outputInput";

// Imagenes necesarias
import imageEsp32 from "@/assets/esp32.png";
import imageReleLogo from "@/assets/releLogo.png";
import imageAgronic from "@/assets/Agronic.png";

export default {
  components: {
    headerCustom,
    customInput,
    customSelect,
    loginButton,
    outputInput,
  },
  data() {
    return {
      listaProgramadores: ["ESP32", "Relé Logo", "Agronic"], // Lista programadores disponibles
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
    ]),
  },
  beforeMount() {
    this.image = this.imagenes[this.tipoProgramador];
  },
  methods: {
    update(event) {
      this.tipoProgramador = event;
      this.image = this.imagenes[this.tipoProgramador];
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";
.registroProgramador {
  display: grid;
  grid-template-columns: 50% 50%;
  grid-template-rows: auto;
  grid-template-areas:
    "head head"
    "id device"
    "salidasDigitales salidasDigitales"
    "entradasDigitales entradasDigitales"
    "salidasAnalogicas salidasAnalogicas"
    "entradasAnalogicas entradasAnalogicas";

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
    height: 33vh;
    .identificadorBody {
      grid-area: id;
      display: flex;
      align-items: center;
      justify-content: flex-start;
      flex-direction: column;
      height: calc(33vh - 22px);

      .input {
        width: 100%;
      }
    }
  }

  .device {
    grid-area: device;
    padding: 0px;
    img {
      max-width: 33vw;
      height: 33vh;
    }
  }

  .salidasDigitales {
    grid-area: salidasDigitales;
  }

  .entradasDigitales {
    grid-area: entradasDigitales;
  }

  .salidasAnalogicas {
    grid-area: salidasAnalogicas;
  }

  .entradasAnalogicas {
    grid-area: entradasAnalogicas;
  }
}
</style>
