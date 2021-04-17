<template>
  <div class="temporizador">
      <h3 :style="{'align-self': title && windowWidth >= 990? 'end' : 'center'}"><slot></slot></h3>
    <div class="inicio">
      <h3 v-if="title || windowWidth < 1030">Hora de inicio</h3>
         <div>
        <number-selector
          :value="inicioHora"
          :min="0"
          :max="99"
          placeholder="Horas"
          :disabled="disabled"
          @input="inicioHora = parseInt($event); update()"
        ></number-selector>
        <number-selector
          :value="inicioMinutos"
          :min="0"
          :max="59"
          placeholder="Min"
          :disabled="disabled"
          @input="inicioMinutos = parseInt($event); update()"
        ></number-selector>
        <number-selector
          :value="inicioSegundos"
          :min="0"
          :max="59"
          placeholder="Seg"
          :disabled="disabled"
          @input="inicioSegundos = parseInt($event); update()"
        ></number-selector>
      </div>
    </div>
    <div class="duracion">
      <h3 v-if="title || windowWidth < 1030">Duración</h3>
      <div>
        <number-selector
          :value="duracionHora"
          :min="0"
          :max="99"
          placeholder="Horas"
          :disabled="disabled"
          @input="duracionHora = parseInt($event); update()"
        ></number-selector>
        <number-selector
          :value="duracionMinutos"
          :min="0"
          :max="59"
          placeholder="Min"
          :disabled="disabled"
          @input="duracionMinutos = parseInt($event); update()"
        ></number-selector>
        <number-selector
          :value="duracionSegundos"
          :min="0"
          :max="59"
          placeholder="Seg"
          :disabled="disabled"
          @input="duracionSegundos = parseInt($event); update()"
        ></number-selector>
      </div>
    </div>
    <div class="postriego">
      <h3 v-if="title || windowWidth < 1030">Tiempo de postriego</h3>
      <div>
        <number-selector
          :value="postHora"
          :min="0"
          :max="99"
          placeholder="Horas"
          :disabled="disabled"
          @input="postHora = parseInt($event); update()"
        ></number-selector>
        <number-selector
          :value="postMinutos"
          :min="0"
          :max="59"
          placeholder="Min"
          :disabled="disabled"
          @input="postMinutos = parseInt($event); update()"
        ></number-selector>
        <number-selector
          :value="postSegundos"
          :min="0"
          :max="59"
          placeholder="Seg"
          :disabled="disabled"
          @input="postSegundos = parseInt($event); update()"
        ></number-selector>
      </div>
    </div>
    <font-awesome-icon :style="{'align-self': title && windowWidth >= 1030? 'end' : 'center'}" @click="$emit('delete',id)" icon="trash-alt" size="2x" />
  </div>
 
</template>

<script>
import NumberSelector from "@/components/NumberSelector";

export default {
  components: {
    NumberSelector
  },
  props: {
      title: Boolean,
      id: Number,
      value: Object,
      disabled: Boolean,
  },
  data() {
    return {
      inicioHora: this.value.inicio[0],
      inicioMinutos: this.value.inicio[1],
      inicioSegundos: this.value.inicio[2],
      duracionHora: this.value.duracion[0],
      duracionMinutos: this.value.duracion[1],
      duracionSegundos: this.value.duracion[2],
      postHora: this.value.post[0],
      postMinutos: this.value.post[1],
      postSegundos: this.value.post[2],
      windowWidth: 0,
      windowHeight: 0,
      
    };
  },
  computed: {
      temporizador(){
        return {
            inicio: [this.inicioHora, this.inicioMinutos, this.inicioSegundos],
            duracion: [this.duracionHora, this.duracionMinutos, this.duracionSegundos],
            post: [this.postHora, this.postMinutos, this.postSegundos]
        }
      }
  },
  
   methods: {
     update(){
    this.$emit("input",this.temporizador);
  },
    getWindowWidth() {
      this.windowWidth = document.documentElement.clientWidth;
    },

    getWindowHeight() {
      this.windowHeight = document.documentElement.clientHeight;
    },
  },
  mounted() {
    this.$nextTick(function () {
      window.addEventListener("resize", this.getWindowWidth);
      window.addEventListener("resize", this.getWindowHeight);

      //Init
      this.getWindowWidth();
      this.getWindowHeight();
    });
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.getWindowWidth);
    window.removeEventListener("resize", this.getWindowHeight);
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.temporizador {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 10px 50px;
  flex-wrap: wrap;
  width: 100%;
  min-width: 220px;
  border: 1px solid $primaryDark;
  border-radius: 15px;
  padding: 20px;
  box-shadow: rgba(22, 62, 93, 0.5) 0px 1px 2px 0px, rgba(60, 64, 67, 0.3) 0px 2px 6px 2px;
  

  .inicio,
  .duracion,
  .postriego {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;

    div {
      display: flex;
    }
  }

  svg {
    margin: 10px;
    margin-top: 20px;
    color: $primaryDark;
    cursor: pointer;

    &:hover {
      color: $primary;
    }
  }

}


@media (max-width: 1030px) {
  .temporizador {
      justify-content: center;
    margin: 10px 15px;
    flex-direction: column;
     width: 30%;
  }
}

@media (max-width: 576px) {
  .temporizador {
    margin: 10px 10px;
  }
}
</style>