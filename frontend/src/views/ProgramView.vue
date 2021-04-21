<template>
  <div class="root">
    <!-- Header con el nombre del programa -->
    <div class="header">
      <h1>{{ name }}</h1>
      <div class="ayuda">
      <a @click.prevent="$tours['myTour'].start()">
        <font-awesome-icon icon="info-circle"/>
      </a>
    </div>
    </div>

    <!-- Botón flotante con el que se puede guardar -->
    <div class="guardar">
      <submit-button>Guardar</submit-button>
    </div>

    

    <!-- Cuerpo donde se va a mostrar todo el contenido de la página -->
    <div class="form">
      <!-- Toggle encargado de activar el programa -->
      <div class="activo">
        <div>
          <h2 for="Activo">Programa:</h2>
          <toggle v-model="programa"></toggle>
          <label for="Activo">{{ isActive }}</label>
        </div>
      </div>

      <!-- Selector de días -->
      <div class="dias">
        <label for="Dias">Seleccione los dias:</label>
        <select-button
          name="Dias"
          :options="['Manual', 'Automático']"
        ></select-button>
        <day-selector></day-selector>
      </div>

      <!-- Selector de fuentes -->
      <div class="fuente">
        <source-selector :options="fuentes">
          <h3>Selecciona una fuente</h3>
        </source-selector>
      </div>

      <!-- Selector de sectores -->
      <div class="secciones">
        <h3 for="">Selecciona los sectores</h3>
        <section-selector></section-selector>
      </div>

      <!-- Seleccion de tipo de emisior -->
      <div class="emisor">
        <div>
          <h3 for="Emisor">Seleccionar tipo de emisor:</h3>
          <select-button
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
          <button id="show-modal" @click="showModal = true">Show Modal</button>
          <!-- use the modal component, pass in the prop -->
          <modal v-if="showModal" @close="showModal = false">
            <h3 slot="header">Seleccione un programa de la lista</h3>
            <div slot="body">
              <list :data="programas"></list>
            </div>

            <div slot="footer">
              El programa empezará tras el programa escogido
            </div>
          </modal>
        </div>
        <div class="temporizadores" v-else>
          <h3 for="Horas">Temporización:</h3>
          <select-button
            :sel="temporizador"
            v-model="temporizador"
            name="temporizacion"
            :options="['Manual', 'Automático']"
          ></select-button>
          <temporizador-menu :disabled="temporizador == 1"></temporizador-menu>
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
import sectionSelector from "@/components/SectionSelector";
import Modal from "@/components/Modal";
import List from "@/components/List";
import Toggle from "@/components/Toggle";
import SubmitButton from "@/components/SubmitButton";
import SelectButton from "@/components/SelectButton";
import temporizadorMenu from "@/components/TemporizadorMenu";

export default {
  components: {
    daySelector,
    sourceSelector,
    sectionSelector,
    Modal,
    List,
    Toggle,
    SubmitButton,
    SelectButton,
    temporizadorMenu,
  },
  data() {
    return {
      programas: this.$root.programas, // TODO: eliminar esto en la version final
      showModal: false, // Variable que indica si mostrar o no el modal
      name: "Programa de riego 1", // Nombre del programa
      fuentes: ["Bombas 1", "Bombas 2", "Bombas 3", "Bombas 4"], // Nombre de las bombas, se pueden especificar los que quieran
      programa: false,
      dias: false,
      horaInicio: false,
      emisor: false,
      temporizador: 0,
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
  },
  methods: {
    goFertirrigacion() {
      this.$router.push("Fertirrigacion");
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.ayuda{
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
    z-index: 9999;

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

.header {
  box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px,
    rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
  padding: 20px;
  margin: 20px;
  margin-bottom: 40px;
  background: linear-gradient($primaryShadow, $secondaryShadow),
    url("../assets/header.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  background-position-y: -150px;
  color: white;
  height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5em;
}

.form {
  display: grid;
  grid-template-columns: auto;
  grid-template-rows: auto;
  grid-template-areas:
    "activo activo"
    "dias fuentes"
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
  }

  .duracion {
    display: flex;
    grid-area: duracion;
  }

  .activo {
    grid-area: activo;
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
  .activo div,
  .dias,
  .hora,
  .fuente,
  .secciones,
  .postriego,
  .fertirrigacion,
  .emisor div:first-child {
    box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
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

@media (max-width: "480px"){
  .ayuda{
    top: 230px;
  }
}
</style>