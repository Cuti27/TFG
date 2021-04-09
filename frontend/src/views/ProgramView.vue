<template>
  <div>
    <div class="header">
      <h1>{{ name }}</h1>
    </div>
    <div class="form">
      <div class="activo">
        <label for="Activo">Programa: </label>
        <input
          name="Activo"
          type="checkbox"
          class="toggle"
          v-model="programa"
        />
        <label for="Activo">{{ isActive }}</label>
      </div>
      <div class="dias">
        <label for="Dias">Dias:</label>
        <input name="Dias" type="checkbox" class="toggle" v-model="dias" />
        <label for="Dias">{{ isManualDay }}</label>
        <day-selector></day-selector>
      </div>

      <div class="hora">
        <label for="Horas">Hora de inicio:</label>
        <input
          name="Horas"
          type="checkbox"
          class="toggle"
          v-model="horaInicio"
        />
        <label for="Horas">{{ isTempHoraInicio }}</label>
        <div v-show="!horaInicio">
          <button id="show-modal" @click="showModal = true">Show Modal</button>
          <!-- use the modal component, pass in the prop -->
          <modal v-if="showModal" @close="showModal = false">
            <h3 slot="header">Seleccione un programa de la lista</h3>
            <div slot='body'>
              <list :data="programas"></list>
            </div>
          </modal>
        </div>
      </div>

      <div class="fuente">
        <label for="">Selecciona una fuente</label>
        <source-selector :options="fuentes"></source-selector>
      </div>

      <div class="secciones">
        <label for="">Selecciona una seccion</label>
        <section-selector></section-selector>
      </div>
      <div class="duracion">
        <label for="">Seleccione el tiempo del programa</label>
        <div class="selectorHora">
          <number-selector
            :value="horas"
            :min="0"
            :max="99"
            placeholder="Horas"
          ></number-selector>
          <number-selector
            :value="horas"
            :min="0"
            :max="59"
            placeholder="Min"
          ></number-selector>
          <number-selector
            :value="horas"
            :min="0"
            :max="59"
            placeholder="Seg"
          ></number-selector>
        </div>
      </div>

      <div class="postriego">
        <label for="">Seleccione el tiempo del postriego</label>
        <div class="selectorHora">
          <number-selector
            :value="horas"
            :min="0"
            :max="99"
            placeholder="Horas"
          ></number-selector>
          <number-selector
            :value="horas"
            :min="0"
            :max="59"
            placeholder="Min"
          ></number-selector>
          <number-selector
            :value="horas"
            :min="0"
            :max="59"
            placeholder="Seg"
          ></number-selector>
        </div>
      </div>

      <div class="fertirrigacion">
        <button>Fertirrigacion</button>
      </div>
    </div>
  </div>
</template>

<script>
import daySelector from "@/components/DaySelector";
import sourceSelector from "@/components/SourceSelector";
import sectionSelector from "@/components/SectionSelector";
import numberSelector from "@/components/NumberSelector";
import Modal from "@/components/Modal";
import List from "@/components/List";

export default {
  components: {
    daySelector,
    sourceSelector,
    sectionSelector,
    numberSelector,
    Modal,
    List
  },
  data() {
    return {
      programas: this.$root.programas,
      showModal: false,
      name: "Programa de riego 1",
      fuentes: [
        "Fuente 1",
        "Fuente 2",
        "Fuente 3",
        "Fuente 4",
        "Fuente 1",
        "Fuente 2",
        "Fuente 3",
        "Fuente 4",
        "Fuente 1",
        "Fuente 2",
        "Fuente 3",
        "Fuente 4",
        "Fuente 1",
        "Fuente 2",
        "Fuente 3",
        "Fuente 4",
      ],
      horas: 10,
      programa: false,
      dias: false,
      horaInicio: false,
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
  },
};
</script>

<style lang="scss" scoped>
.header {
 box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
  padding: 20px;
  margin: 30px;
  margin-bottom: 40px;
}

.form {
  display: grid;
  grid-template-columns: auto;
  grid-template-rows: auto;
  grid-template-areas:
    "activo fuentes"
    "dias fuentes"
    "hora hora"
    "duracion secciones"
    "postriego secciones"
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

  .duracion {
    display: flex;
    grid-area: duracion;
  }

  .activo {
    grid-area: activo;
  }

  .dias {
    grid-area: dias;
  }

  .hora {
    grid-area: hora;
  }

  .duracion, .activo, .dias, .hora, .fuente, .secciones,
  .postriego, .fertirrigacion{
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

  input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    -webkit-tap-highlight-color: transparent;
    cursor: pointer;
    &:focus {
      outline: 0;
    }
  }
  .toggle {
    height: 32px;
    width: 52px;
    border-radius: 16px;
    display: inline-block;
    position: relative;
    margin: 0;
    border: 2px solid #474755;
    // background: linear-gradient(180deg, #2d2f39 0%, #1f2027 100%);
    background: rgba(150, 150, 150, 0.6);
    transition: all 0.2s ease;
    &:after {
      content: "";
      position: absolute;
      top: 2px;
      left: 2px;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: white;
      box-shadow: 2px 2px 2px rgba(44, 44, 44, 0.2);
      transition: all 0.2s cubic-bezier(0.5, 0.1, 0.75, 1.35);
    }
    &:checked {
      border-color: #654fec;
      background: #654fec;
      &:after {
        transform: translatex(20px);
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
      "hora hora"
      "secciones secciones"
      "duracion postriego"
      "ferrigacion ferrigacion";
  }
}

@media (max-width: 576px) {
  .form {
    grid-template-areas:
      "activo activo"
      "dias dias"
      "fuentes fuentes"
      "hora hora"
      "secciones secciones"
      "duracion duracion"
      "postriego postriego"
      "ferrigacion ferrigacion";
    .fertirrigacion {
      grid-column-start: col-start -2;
    }
  }

}
</style>