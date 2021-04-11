<template>
  <div>
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

    <div class="ph">
       <number-selector
            :value="ph"
            :min="0"
            :max="14"
            placeholder="pH"
            @input="updatePH(parseInt($event))"
          ></number-selector>
    </div>

    <div class="control">
      <label for="control">CONTROL DE ABONADO: </label>
      <toggle v-model="control"></toggle>
      <label for="control">{{ isSecuencial }}</label>
    </div>

    <div class="lineaAbono"></div>

    <div class="selectorAbono"></div>

    <div class="control">
      <div class="selector"></div>
      <div class="consigna"></div>
      <div class="tiempo"></div>
    </div>
  </div>
</template>

<script>
import Toggle from "@/components/Toggle";
import numberSelector from "@/components/NumberSelector";
export default {
  components: { Toggle, numberSelector },
  data() {
    return {
      phPre: false,
      phRie: false,
      phPost: false,
      control: false,
      ph: 0
    };
  },
  methods: {
      isActive(bool){
          return bool ? "Activo" : "Desactivo"
      },
      updatePH(value){
          console.log(value);
          this.ph = value;
      }
},
computed: {
    isSecuencial(){
        return this.control ? "Simultáneo" : "Secuencial"
    }
}
};
</script>

<style>
</style>