 <template>
 <div>
 <list :data="cabezales">
      <h1>Cabezales</h1>
    </list>
    <hr />
    <list :data="programas">
      <h1>Programas</h1>
    </list>
    <!-- <hr />
    <programa :programa="programas[0]"></programa> -->
    <hr />
    <day-selector :value="dias"><span>Seleccione un día válido:</span></day-selector>
    <hr />.
    <toggle></toggle>
    <hr>
    <custom-select @change="selected = $event;print(selected)" :selected="selected" :values="sel"></custom-select>
    <hr>
    <submit-button>Guardar</submit-button>
    <hr>
    <div>
      <custom-button>Prueba</custom-button>
    </div>

    <hr>
    <select-button :options="['Manual', 'Automatico', ]"></select-button>
    <hr>
    <div class="temporizadores">
      <temporizador v-model="temporizador1" :title="true">Temporizador 1</temporizador>
      <temporizador>Temporizador 2</temporizador>
      <temporizador>Temporizador 3</temporizador>
      <submit-button>Nuevo temporizador</submit-button>
    </div>
    <hr>
    <temporizador-menu></temporizador-menu>
  </div>
</template>

<script>
import List from "@/components/List.vue";
// import Programa from "./views/Programa.vue";
import daySelector from "@/components/DaySelector";
import Toggle from "@/components/Toggle";
import customSelect from "@/components/Select";
import SubmitButton from "@/components/SubmitButton";
import CustomButton from "@/components/CustomButton";
import SelectButton from "@/components/SelectButton";
import Temporizador from '@/components/Temporizador.vue';
import temporizadorMenu from "@/components/TemporizadorMenu"

export default {
  components: {
    List,
    // Programa,
    daySelector,
    Toggle,
    customSelect,
    SubmitButton,
    CustomButton,
    SelectButton,
    Temporizador,
    temporizadorMenu
  },
  data() {
    return {
      cabezales: this.$root.cabezales,
      programas: this.$root.programas,
      dias: [false, false, false, false, false, true, true],
      checked: false,
      sel: ["Hola","Adios", "Buenas noches"],
      selected: 0,
      temporizador1: [],
    };
  },
  methods: {
    print(value){
      console.log(value)
    }
  }
};
</script>


<style lang="scss" scoped>

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
