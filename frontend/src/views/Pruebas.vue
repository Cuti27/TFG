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
    <custom-select :values="sel"></custom-select>
  </div>
</template>

<script>
import List from "@/components/List.vue";
// import Programa from "./views/Programa.vue";
import daySelector from "@/components/DaySelector";
import Toggle from "@/components/Toggle"
import customSelect from "@/components/Select"
export default {
  components: {
    List,
    // Programa,
    daySelector,
    Toggle,
    customSelect
  },
  data() {
    return {
      cabezales: this.$root.cabezales,
      programas: this.$root.programas,
      dias: [false, false, false, false, false, true, true],
      checked: false,
      sel: ["Hola","Adios", "Buenas noches"]
    };
  },
};
</script>


<style lang="scss">
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
