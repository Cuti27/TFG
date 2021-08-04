<template>
  <form>
    <table :ref="`table_${title}`" :class="{ style: checkStyle() }">
      <caption>
      <div class="center">
        {{
          title
        }}
        <div >
          <span class="input-number-decrement" @click="disminuir()">–</span
          ><input
            class="input-number"
            type="text"
            v-model="copy"
            min="0"
          /><span class="input-number-increment" @click="aumentar()">+</span>
        </div>
      </div>
        
      </caption>
      <thead>
        <tr>
          <th scope="col">{{ type }}</th>
          <th scope="col">Selecciona uno</th>
          <th scope="col">Nombre</th>
          <th v-if="nombre" scope="col">Descripcion</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(n, index) in parseInt(numValues)"
          :key="`${title}_column_${n}`"
        >
          <td :data-label="type">{{ n }}</td>
          <td data-label="Selecciona uno">
            <br>
            <custom-select
              class="select"
              button
              :width="160"
              @change="updateSelect($event, index)"
              :selected="selected[index].type - 1"
              :values="optionsName"
            ></custom-select>
          </td>
          <td v-if="nombre" data-label="Nombre">
            <v-text-field
              class="name"
              v-model="selected[index].name"
              label="Nombre"
              hide-details="auto"
            ></v-text-field>
          </td>
          <td data-label="Descripcion">
            <textarea
              v-model="selected[index].description"
              placeholder="Descripción opcional"
            />
          </td>
        </tr>
        <tr v-if="showSave">
          <td></td>
          <td><v-btn @click="actualizar()">Guardar</v-btn></td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </form>
</template>

<script>
import customSelect from "@/components/Select";
import { mapGetters } from "vuex";

export default {
  components: { customSelect },
  props: {
    options: Array,
    type: String,
    title: String,
    vuexSelect: String,
    nombre: Boolean,
  },
  data() {
    return {
      selected: [],
      width: -1,
      copy: 0,
      name: "",
    };
  },
  watch: {
    copy() {
      if (this.numValues < this.copy)
        while (this.numValues != this.copy) this.aumentar();
      else if (this.numValues > this.copy)
        while (this.numValues != this.copy) this.disminuir();
    },
    numValues() {
      this.copy = this.numValues;
    },
    configureDeviceOutputInput: {
      deep: true,
      handler: "startComponent",
    },
  },
  methods: {
    checkStyle() {
      if (this.width !== -1) {
        const ref = `table_${this.title}`;
        this.width = this.$refs[ref].clientWidth;
        return this.width <= 600;
      }
      return false;
    },
    aumentar() {
      this.selected.push({ type: 1, description: "" });
    },
    disminuir() {
      if (this.numValues >= 1) {
        this.selected.pop();
      }
    },
    actualizar() {
      if (this.nombre) this.selected.name = this.name;
      this.$emit("update", this.selected);
    },
    inputNumber(value) {
      console.log(value);
    },
    updateSelect(registro, index) {
      this.selected[index].type = registro + 1;
    },
    startComponent(newVal) {
      console.log(newVal);
      this.selected = JSON.parse(JSON.stringify(this.startSelect));
      this.copy = this.numValues;
    },
  },
  computed: {
    ...mapGetters({
      outputInput: "configureDeviceOutputInput",
    }),

    startSelect() {
      return this.outputInput[this.vuexSelect];
    },

    optionsName() {
      return this.options.map((a) => a.type);
    },
    numValues() {
      return this.selected.length;
    },
    showSave() {
      console.log("Comprobacion");
      if (this.nombre) console.log("yo");
      console.log(this.selected);
      console.log(this.startSelect);
      console.log(this.selected.length);
      console.log(this.startSelect.length);
      console.log(this.selected.length != this.startSelect.length);

      if (this.selected.length != this.startSelect.length) return true;
      console.log("Esto si");
      if (this.selected.length == 0 && this.startSelect.lenght == 0)
        return false;
      console.log("what");
      for (let element of this.selected) {
        let check = false;
        for (let element2 of this.startSelect) {
          let firstIsNullOrEmpty =
            element.description == null || element.description == "";
          let secondIsNullOrEmpty =
            element2.description == null || element2.description == "";
          if (
            element.type == element2.type &&
            element.description == element.description &&
            (firstIsNullOrEmpty == secondIsNullOrEmpty ||
              element.description == element2.description)
          ) {
            if (this.nombre) {
              if (element.name == element2.name) {
                console.log("Iguales");
                console.log(element);
                console.log(element2);
                check = true;
                break;
              }
            } else {
              console.log("Iguales");
              console.log(element);
              console.log(element2);
              check = true;
              break;
            }
          }
        }

        if (!check && this.startSelect.length > 0) {
          console.log("No iguales");
          console.log(element);
          return true;
        }
      }
      return false;
    },
  },

  created() {
    this.startComponent();
  },
  mounted() {
    this.$nextTick(function () {
      const ref = `table_${this.title}`;
      this.width = this.$refs[ref].clientWidth;
      window.addEventListener("resize", this.checkStyle);
    });
    this.checkStyle();
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.checkStyle);
  },
};
</script>

<style lang="scss" scoped>
.name {
  width: 70%;
}

table {
  table-layout: fixed;
  border: 1px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  max-width: 100%;
  caption {
    font-size: 1.5em;
    margin: 0.5em 0 0.75em;
  }
  tr {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: 0.35em;
  }
  th,
  td {
    padding: 0.625em;
    text-align: center;
  }
  th {
    font-size: 0.85em;
    letter-spacing: 0.1em;
    text-transform: uppercase;
  }
}

.center {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 0px;
  width: 100%;
  flex-direction: column;
}

.input-number {
  width: 80px;
  padding: 0 12px;
  vertical-align: top;
  text-align: center;
  outline: none;
}

.input-number,
.input-number-decrement,
.input-number-increment {
  border: 1px solid #ccc;
  height: 40px;
  user-select: none;
}

.input-number-decrement,
.input-number-increment {
  display: inline-block;
  width: 30px;
  line-height: 38px;
  background: #f1f1f1;
  color: #444;
  text-align: center;
  font-weight: bold;
  cursor: pointer;

  &:active {
    background: #ddd;
  }

  .input-number-decrement {
    border-right: none;
    border-radius: 4px 0 0 4px;
  }

  .input-number-increment {
    border-left: none;
    border-radius: 0 4px 4px 0;
  }
}

.style {
  border: 0;

  caption {
    font-size: 1.3em;
  }

  thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }

  tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: 0.625em;
  }

  td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: 0.8em;
    text-align: right;
  }
  td::before {
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  td:last-child {
    border-bottom: 0;
  }
}

textarea {
  width: 95%;
  height: 50px;
  -moz-border-bottom-colors: none;
  -moz-border-left-colors: none;
  -moz-border-right-colors: none;
  -moz-border-top-colors: none;
  background: none repeat scroll 0 0 rgba(0, 0, 0, 0.07);
  border-color: -moz-use-text-color #ffffff #ffffff -moz-use-text-color;
  border-image: none;
  border-radius: 6px 6px 6px 6px;
  border-style: none solid solid none;
  border-width: medium 1px 1px medium;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.12) inset;
  color: #555555;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 1em;
  line-height: 1.4em;
  padding: 5px 8px;
  transition: background-color 0.2s ease 0s;

  textarea:focus {
    background: none repeat scroll 0 0 #ffffff;
    outline-width: 0;
  }
}
</style>
