<template>
  <div class="root">
    <div class="header">
      <h1>{{ name }}</h1>
    </div>
    <div class="guardar">
      <submit-button>Guardar</submit-button>
    </div>
    <div class="form">
      <div class="activo">
        <h2 for="Activo">Programa: </h2>
        <toggle v-model="programa"></toggle>
        <label for="Activo">{{ isActive }}</label>
      </div>
      <div class="dias">
        <label for="Dias">Seleccione los dias:</label>
        <select-button name="Dias" :options="['Manual', 'Automático']"></select-button>
        <day-selector></day-selector>
      </div>

      <div class="hora">
        <div class="horaHead">
          <h3 for="Horas">Hora de inicio:</h3>
          
           <select-button xl v-model="horaInicio" name="hora" :options="['Despues de programa','Mediante temporizador']"></select-button>
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
           <select-button :sel="temporizador" v-model="temporizador" name="temporizacion" :options="['Manual', 'Automático']"></select-button>
          <temporizador-menu :disabled="temporizador == 1"></temporizador-menu>
        </div>
      </div>
      <div class="emisor">
        <h3 for="Emisor">Seleccionar tipo de emisor:</h3>
        <select-button name="Emisor" :options="['Aspersion', 'Goteo']"></select-button>
      </div>
      <div class="fuente">
        <source-selector :options="fuentes">
          <h3>Selecciona una fuente</h3> 
        </source-selector>
      </div>

      <div class="secciones">
        <h3 for="">Selecciona los sectores</h3>
        <section-selector></section-selector>
      </div>

      <div class="fertirrigacion">
        <submit-button @click="goFertirrigacion()">Fertirrigacion</submit-button>
      </div>
    </div>
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
    temporizadorMenu
  },
  data() {
    return {
      programas: this.$root.programas,
      showModal: false,
      name: "Programa de riego 1",
      fuentes: ["Bombas 1", "Bombas 2", "Bombas 3", "Bombas 4"],
      horas: 10,
      minutos: 10,
      segundos: 10,
      postHoras: 10,
      postMinutos: 10,
      postSegundos: 10,
      programa: false,
      dias: false,
      horaInicio: false,
      emisor: false,
      temporizador: 0
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
  methods:{
    goFertirrigacion(){
      this.$router.push("Fertirrigacion");
    }
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

h3{
  margin-bottom: 5px;
}

.guardar {
  position: fixed;
  bottom: 50px;
  right: 80px;
  z-index: 9999;
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
    "activo ."
    "dias dias"
    "fuentes fuentes"
    "secciones secciones"
    "emisor emisor"
    "hora hora"
    "duracion postriego"
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
  .activo,
  .dias,
  .hora,
  .fuente,
  .secciones,
  .postriego,
  .fertirrigacion,
  .emisor {
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    border-radius: 5px;
    margin: 10px;
    padding: 10px 15px;
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
    

  .guardar{
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
    "duracion postriego"
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

  .guardar{
    right: 70px;
    a {
      font-size: 0.9em;
    }
  }
}
</style>