<template>
  <div class="view">
    <header-custom name="Configuracion de Fertirrigación"></header-custom>
    <div class="phControl">
      <div class="phPre">
        <label for="phPre">CONTROL DE pH EN PRERIEGO: </label>
        <toggle v-model="phPre"></toggle>
        <label for="phPre">{{ isActive(phPre) }}</label>
      </div>
      <div class="phRie">
        <label for="phRie">CONTROL DE pH EN RIEGO: </label>
        <toggle v-model="phRie"></toggle>
        <label for="phRie">{{ isActive(phRie) }}</label>
      </div>

      <div class="phPost">
        <label for="phPost">CONTROL DE pH EN POSTRIEGO: </label>
        <toggle v-model="phPost"></toggle>
        <label for="phPost">{{ isActive(phPost) }}</label>
      </div>
    </div>

    <div class="ph">
      <number-selector
        :value="ph"
        :min="0"
        :max="14"
        placeholder="pH"
        @input="updatePH(parseInt($event))"
      ></number-selector>
    </div>

    <div class="controlAbono">
      <label for="control">CONTROL DE ABONADO: </label>
      <toggle v-model="control"></toggle>
      <label for="control">{{ isSecuencial }}</label>
    </div>

    <div class="lineaAbono">
      <source-selector :options="abonos"></source-selector>
    </div>

    <div class="selectorAbono">
      <custom-select
        :button="true"
        @change="selected = $event"
        :selected="selected"
        :values="sel"
      ></custom-select>
    </div>

    <div class="selector">
      <custom-select
        @change="medicionSelected = $event"
        :selected="medicionSelected"
        :values="medicion"
      ></custom-select>
    </div>
    <div class="consigna">
      <custom-input
        :type="typeConsigna"
        step="1"
        v-model="consigna"
        placeholder="Consignia"
      />
    </div>
    <div class="tiempo">
      <custom-input
        type="time"
        step="1"
        v-model="tiempoAbono"
        placeholder="Tiempo "
      />
    </div>
  </div>
</template>

<script>
import Toggle from "@/components/Toggle";
import numberSelector from "@/components/NumberSelector";
import customSelect from "@/components/Select";
import CustomInput from "@/components/CustomInput";
import SourceSelector from "@/components/SourceSelector";
import headerCustom from "@/components/Header";
export default {
  components: {
    Toggle,
    numberSelector,
    customSelect,
    CustomInput,
    SourceSelector,
    headerCustom
  },
  data() {
    return {
      phPre: false,
      phRie: false,
      phPost: false,
      control: false,
      ph: 0,
      selected: 0,
      sel: ["Abono 1", "Abono 2", "Abono 3", "Abono 4", "Abono 5", "Abono 6"],
      medicion: ["Tiempo", "Volumen", "Proporcional"],
      medicionSelected: 0,
      consigna: "",
      tiempoAbono: 0,
      abonos: [1, 2, 3, 4, 5, 6, 7],
    };
  },
  methods: {
    isActive(bool) {
      return bool ? "Activo" : "Desactivo";
    },
    updatePH(value) {
      console.log(value);
      this.ph = value;
    },
  },
  computed: {
    isSecuencial() {
      return this.control ? "Simultáneo" : "Secuencial";
    },
    typeConsigna() {
      if (this.medicionSelected == 0) return "time";
      else return "number";
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.view {
  display: grid;
  grid-template-columns: auto;
  grid-template-rows: auto;
  grid-template-areas:
    "header header"
    "phControl ph"
    "phControl ph"
    "phControl  lineaAbono"
    "controlAbono lineaAbono"
    "selectorAbono selector"
    "consigna tiempo";

  .phControl,
  .ph,
  .controlAbono,
  .lineaAbono,
  .selectorAbono,
  .consigna,
  .selector,
  .tiempo,
  .header {
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    border-radius: 5px;
    margin: 10px;
    padding: 10px 15px;
    background: $white;
  }

  .header {
    grid-area: header;
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

  .phControl {
    grid-area: phControl;
  }

  .ph {
    grid-area: ph;
  }

  .controlAbono {
    grid-area: controlAbono;
  }

  .lineaAbono {
    grid-area: lineaAbono;
  }

  .selectorAbono {
    grid-area: selectorAbono;
  }

  .consigna {
    grid-area: consigna;
  }
  .selector {
    grid-area: selector;
  }
  .tiempo {
    grid-area: tiempo;
  }
}

@media (max-width: 768px) {
  .view {
    grid-template-areas:
    "header header"
      "phControl phControl"
      "ph  lineaAbono"
      "controlAbono controlAbono"
      "selectorAbono selector"
      "consigna consigna"
      "tiempo tiempo";
  }
}

@media (max-width: 633px) {
  .view {
    grid-template-areas:
    "header header"
      "phControl phControl"
      "ph ph"
      "controlAbono controlAbono"
      "lineaAbono lineaAbono"
      "selectorAbono selectorAbono"
      "selector selector"
      "consigna consigna"
      "tiempo tiempo";
  }
}
</style>