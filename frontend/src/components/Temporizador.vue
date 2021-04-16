<template>
  <div class="temporizador">
      <h3><slot></slot></h3>
    <div class="inicio">
      <h3 v-if="title || windowWidth < 950">Hora de inicio</h3>
      <div>
        <number-selector
          :value="inicioHora"
          :min="0"
          :max="99"
          placeholder="Horas"
          @input="inicioHora = value"
        ></number-selector>
        <number-selector
          :value="inicioMinutos"
          :min="0"
          :max="59"
          placeholder="Min"
          @input="inicioMinutos = value"
        ></number-selector>
        <number-selector
          :value="inicioSegundos"
          :min="0"
          :max="59"
          placeholder="Seg"
          @input="inicioSegundos = value"
        ></number-selector>
      </div>
    </div>
    <div class="duracion">
      <h3 v-if="title || windowWidth < 950">Duración</h3>
      <div>
        <number-selector
          :value="duracionHora"
          :min="0"
          :max="99"
          placeholder="Horas"
          @input="duracionHora = value"
        ></number-selector>
        <number-selector
          :value="duracionMinutos"
          :min="0"
          :max="59"
          placeholder="Min"
          @input="duracionMinutos = value"
        ></number-selector>
        <number-selector
          :value="duracionSegundos"
          :min="0"
          :max="59"
          placeholder="Seg"
          @input="duracionSegundos = value"
        ></number-selector>
      </div>
    </div>
    <div class="postriego">
      <h3 v-if="title || windowWidth < 950">Tiempo de postriego</h3>
      <div>
        <number-selector
          :value="postHora"
          :min="0"
          :max="99"
          placeholder="Horas"
          @input="postHoras = value"
        ></number-selector>
        <number-selector
          :value="postMinutos"
          :min="0"
          :max="59"
          placeholder="Min"
          @input="postMinutos = value"
        ></number-selector>
        <number-selector
          :value="postSegundos"
          :min="0"
          :max="59"
          placeholder="Seg"
          @input="postSegundos = value"
        ></number-selector>
      </div>
    </div>
  </div>
</template>

<script>
import NumberSelector from "@/components/NumberSelector";
export default {
  components: {
    NumberSelector,
  },
  props: {
      title: Boolean
  },
  data() {
    return {
      inicioHora: 0,
      inicioMinutos: 0,
      inicioSegundos: 0,
      duracionHora: 0,
      duracionMinutos: 0,
      duracionSegundos: 0,
      postHora: 0,
      postMinutos: 0,
      postSegundos: 0,
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
.temporizador {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 10px 50px;
  flex-wrap: wrap;
  width: 100%;
  min-width: 220px;

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
}


@media (max-width: 970px) {
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