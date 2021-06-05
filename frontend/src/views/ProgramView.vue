<template>
  <div class="root">
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
    <!-- Header con el nombre del programa -->
    <header-custom :name="name">
      <div class="ayuda">
        <a @click.prevent="$tours['myTour'].start()">
          <font-awesome-icon icon="info-circle" />
        </a>
      </div>
    </header-custom>

    <!-- Botón flotante con el que se puede guardar -->
    <div class="guardar">
      <submit-button @click="saveProgram">Guardar</submit-button>
    </div>

    <!-- Cuerpo donde se va a mostrar todo el contenido de la página -->
    <div class="form">
      <!-- Toggle encargado de activar el programa -->
      <div class="activo">
        <div>
          <h3 for="Activo">Programa:</h3>
          <v-switch v-model="programa" :label="isActive"></v-switch>
        </div>
      </div>

      <!-- Selector de días -->
      <div class="dias">
        <h3 for="Dias">Seleccione los dias:</h3>
        <select-button
          @input="updateAutomatico"
          name="Dias"
          :options="['Manual', 'Automático']"
        ></select-button>
        <day-selector></day-selector>
      </div>

      <!-- Selector de fuentes -->
      <div class="fuente">
        <source-selector @toggle="updateEmitter" :options="computedEmitter">
          <h3>Selecciona una fuente</h3>
        </source-selector>
      </div>

      <!-- Selector de sectores -->
      <div class="secciones">
        <h3 for="">Selecciona entre las opciones</h3>
        <!-- <section-selector></section-selector> -->
        <select-button
          v-model="map"
          name="seccion"
          :options="['Mapa', 'Sectores']"
        ></select-button>

        <div class="map" v-if="!map" key="map">
          <img src="../assets/map-placeholder.jpg" alt="Mapa de prueba" />
        </div>
        <source-selector
          v-else
          @toggle="updateSector"
          :options="computedSector"
        >
          <h3>Selecciona Los sectores</h3>
        </source-selector>
      </div>

      <!-- Seleccion de tipo de emisior -->
      <div class="emisor">
        <div>
          <h3 for="Emisor">Seleccionar tipo de emisor:</h3>
          <select-button
            v-model="goteo"
            name="Emisor"
            :options="['Aspersion', 'Goteo']"
          ></select-button>
        </div>
      </div>

      <!-- Selector de  tiempo-->
      <div class="hora">
        <div class="horaHead">
          <h3 for="Horas">Hora de inicio:</h3>

          <select-button
            xl
            v-model="horaInicio"
            name="hora"
            :options="['Despues de programa', 'Mediante temporizador']"
          ></select-button>
        </div>

        <div v-if="!horaInicio">
          <!-- use the modal component, pass in the prop -->
          <program-list :show="true"></program-list>
        </div>
        <div class="temporizadores" v-else>
          <h3 for="Horas">Temporización:</h3>
          <select-button
            :sel="temporizador"
            v-model="temporizador"
            name="temporizacion"
            :options="['Manual', 'Automático']"
          ></select-button>
          <temporizador-menu
            @update="updateTemporizadores"
            :disabled="temporizador == 1"
          ></temporizador-menu>
        </div>
      </div>

      <!-- Acceso al panel de fertirrigacion -->
      <div class="fertirrigacion">
        <submit-button @click="goFertirrigacion()"
          >Fertirrigacion</submit-button
        >
      </div>
    </div>

    <v-tour name="myTour" :steps="steps" :options="myOptions"></v-tour>
  </div>
</template>

<script>
import daySelector from "@/components/DaySelector";
import sourceSelector from "@/components/SourceSelector";
// import sectionSelector from "@/components/SectionSelector";
import SubmitButton from "@/components/SubmitButton";
import SelectButton from "@/components/SelectButton";
import temporizadorMenu from "@/components/TemporizadorMenu";
import headerCustom from "@/components/Header";
import programList from "@/components/vuetify/dialog/programDialog";

import { mapGetters, mapActions } from "vuex";

export default {
  components: {
    daySelector,
    sourceSelector,
    // sectionSelector,
    programList,
    SubmitButton,
    SelectButton,
    temporizadorMenu,
    headerCustom,
  },
  data() {
    return {
      error: "",
      temporizadores: [],
      selectedEmitter: [],
      selectedSector: [],
      selectedTimer: [],
      diasAutomatico: false,
      goteo: 0,
      showModal: false, // Variable que indica si mostrar o no el modal
      programa: false,
      dias: false,
      horaInicio: false,
      emisor: false,
      temporizador: 0,
      map: true,
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
          target: ".activo",
          header: {
            title: "Activación del programa",
          },
          content: "Permite activar el programa actual",
        },
        {
          target: ".dias",
          header: {
            title: "Dias de activación",
          },
          content:
            "Escoge como se van a realizar la selección de los días de manera automática o manual. En caso de ser manual debe escoger los días de la lista ",
        },
        {
          target: ".fuente",
          header: {
            title: "Fuentes disponibles",
          },
          content:
            "Selecciona las fuen que deseas activar (azul significa que se ha escogido, blanco significa que no)",
        },
        {
          target: ".secciones",
          header: {
            title: "Secciones disponibles",
          },
          content:
            "Puedes escoger atraves de un mapa o atraves de de un seleccionable los sectores que se desean regar (azul significa que se ha escogido, blanco significa que no)",
        },
        {
          target: ".emisor",
          header: {
            title: "Tipo de emision",
          },
          content: "Permite escoger entre riego por aspersión o por goteo",
        },
        {
          target: ".hora",
          header: {
            title: "Programación temporal",
          },
          content:
            "En primer lugar se debe escoger si se quiere programar despues de un programa o mediante temporizadores. En caso de ser por temporizadores, se puede escoger de manera manual y poner tantos como quieras. Como de manera automática y se decidirá automáticamente los tiempos",
        },
        {
          target: ".fertirrigacion",
          header: {
            title: "Fertirrigación",
          },
          content:
            "Permite acceder al programa de fertirrigación, que se asociará a este programa",
        },
      ],
    };
  },
  computed: {
    ...mapGetters(["emitter", "sectors", "programDays"]),
    ...mapGetters({
      name: "programName", // Nombre del programa
    }),
    isActive() {
      return this.programa ? "Activado" : "Desactivado";
    },
    isManualDay() {
      return this.dias ? "Automático" : "Manual";
    },
    isTempHoraInicio() {
      return this.horaInicio
        ? "Programación por parte del usuario"
        : "Despues de un programa";
    },
    isEmisor() {
      return this.emisor ? "Goteo" : "Aspersion";
    },
    computedEmitter() {
      let array = [];
      this.emitter.forEach((element) => {
        array.push(`${element.device.name}: ${element.output.name}`);
      });
      return array;
    },
    computedSector() {
      let array = [];
      this.sectors.forEach((element) => {
        array.push(`${element.device.name}: ${element.output.name}`);
      });
      return array;
    },
  },
  methods: {
    ...mapActions(["createProgram"]),
    goFertirrigacion() {
      this.$router.push("Fertirrigacion");
    },
    updateEmitter($event) {
      console.log("Emitter");
      console.log($event);
      this.selectedEmitter = $event;
    },
    updateSector($event) {
      console.log("Sector");
      console.log($event);
      this.selectedSector = $event;
    },
    updateTemporizadores($event) {
      console.log("Temporizadores");
      console.log($event);
      this.selectedTimer = $event;
    },
    updateAutomatico($event) {
      console.log("Dias automaticos o manuales");
      this.diasAutomatico = $event == 1;
      console.log(this.diasAutomatico);
    },
    saveProgram() {
      const selectedDay = this.programDays.find((element) => element);

      const atLeatSelectedEmitter =
        this.selectedEmitter.find((element) => element) &&
        this.selectedEmitter.length != 0;

      const atLeatSelectedSector =
        this.selectedSector.find((element) => element) &&
        this.selectedSector.length != 0;
      // temporizador

      const aNullInManualTimer =
        (this.selectedTimer.find(
          (element) =>
            element.duracion == null ||
            element.inicio == null ||
            element.post == null ||
            element.duracion == "" ||
            element.inicio == "" ||
            element.post == ""
        ) &&
          this.temporizador == 0) ||
        this.selectedTimer == 0;
      if (!selectedDay) {
        this.error = "Debe seleccionar al menos un día de la semana";
      } else if (!atLeatSelectedEmitter) {
        this.error =
          "Debe seleccionar al menos una bomba (o emisor) para poder programarlo";
      } else if (!atLeatSelectedSector) {
        this.error = "Debe seleccionar al menos una seccion";
      } else if (aNullInManualTimer && this.horaInicio) {
        this.error =
          "Si selecciona un temporizador manual debe rellenar correctamente todos los campos de todos los temporizadores";
      }

      let listTimer = this.selectedTimer.map((element) => {
        return {
          timeStart: element.inicio,
          duration: element.duracion,
          postIrrigation: element.post,
        };
      });
      let programa = {
        autoTimer: this.temporizador,
        afterProgram: !this.horaInicio,
        active: this.programa == 1,
        automaticDays: this.diasAutomatico,
        programDays: this.programDays,
        emitter: this.selectedEmitter,
        sector: this.selectedSector,
        drip: this.goteo == 1,
        timer: listTimer,
      };
      console.log(programa);
      this.createProgram(programa);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.map {
  img {
    width: 100%;
    max-width: 600px;
  }
}

.ayuda {
  display: inline-block;
  margin: 0.15em;
  position: absolute;
  font-size: 1.2em;
  $timing: 265ms;
  $iconColor: $primary;
  $accent: $primaryDark;
  $bluefade: $secondary;

  top: 190px;
  right: 30px;
  z-index: 9990;

  @mixin transformScale($size: 1) {
    transform: scale($size);
    -ms-transform: scale($size);
    -webkit-transform: scale($size);
  }

  svg {
    color: $white;
    position: absolute;
    top: 6px;
    left: 5px;
    transition: all $timing ease-out;
  }

  a {
    display: inline-block;
    padding: 0px;
    &:before {
      @include transformScale();
      content: " ";
      width: 40px;
      height: 40px;
      border-radius: 100%;
      display: block;
      background: linear-gradient(45deg, $iconColor, $accent);
      transition: all $timing ease-out;
    }

    &:hover:before {
      transform: scale(0);
      transition: all $timing ease-in;
    }

    &:hover svg {
      @include transformScale(2.2);
      color: $white;
      -webkit-text-fill-color: transparent;
      transition: all $timing ease-in;
    }
  }
}

h3 {
  margin-bottom: 5px;
}

.onTop {
  position: fixed;
  z-index: 9950;
  top: 10px;
}

.guardar {
  position: fixed;
  bottom: 50px;
  right: 80px;
  z-index: 9990;
}

.buttonTemp {
  padding-left: 10px;
  color: $primary;
  cursor: pointer;
  :hover {
    color: $primaryDark;
  }
}

.form {
  display: grid;
  grid-template-columns: auto;
  grid-template-rows: auto;
  grid-template-areas:
    "activo activo"
    "dias dias"
    "fuentes fuentes"
    "secciones secciones"
    "emisor emisor"
    "hora hora"
    "fertirrigacion fertirrigacion";
  align-items: center;
  margin: 0;
  padding: 0;
  margin-top: 10px;

  div {
    padding-top: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
  }

  .emisor {
    grid-area: emisor;
    div {
      width: 100%;
    }
  }

  .duracion {
    display: flex;
    grid-area: duracion;
  }

  .activo {
    grid-area: activo;
    div:first-child {
      display: flex;
      justify-content: space-between;
      width: 35vw;
      align-items: center;
      max-width: 340px;
    }
  }

  .dias {
    grid-area: dias;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
  }

  .hora {
    grid-area: hora;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    .temporizadores {
      padding-left: 10px;
    }
  }

  .duracion,
  .activo div:first-child,
  .dias,
  .hora,
  .fuente,
  .secciones,
  .postriego,
  .fertirrigacion,
  .emisor div:first-child {
    box-shadow: 5px 5px 15px $primaryDark, -5px -5px 15px #ffffff;
    border-radius: 5px;
    margin: 10px;
    padding: 10px 15px;
    background: $white;
  }

  .hora,
  .activo,
  .dias {
    input {
      margin-left: 10px;
      margin-right: 10px;
    }
  }

  .fuente {
    grid-area: fuentes;
  }
  .secciones {
    grid-area: secciones;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
  }

  .postriego {
    grid-area: postriego;
  }

  .fertirrigacion {
    grid-area: fertirrigacion;
  }
}
@media (max-width: 1200px) {
  .form {
    grid-template-columns: 50% 50%;

    .guardar {
      right: 100px;
      a {
        font-size: 1em;
      }
    }
  }
}

@media (max-width: 768px) {
  .form {
    grid-template-areas:
      "activo activo"
      "dias dias"
      "fuentes fuentes"
      "secciones secciones"
      "emisor emisor"
      "hora hora"
      "fertirrigacion fertirrigacion";
    .fertirrigacion {
      grid-column-start: col-start -3;
    }
  }
}

@media (max-width: 576px) {
  .form {
    .fertirrigacion {
      grid-column-start: col-start -2;
    }
  }

  .guardar {
    right: 70px;
    a {
      font-size: 0.9em;
    }
  }
}

@media (max-width: "480px") {
  .ayuda {
    top: 230px;
  }
}
</style>
