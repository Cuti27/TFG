<template>
  <form>
    <table :ref="`table_${title}`" :class="{ style: checkStyle() }">
      <caption>
        {{
          title
        }}
      </caption>
      <!-- TODO: Boton con el guardado -->
      <div class="botonera">
        <custom-input
          type="number"
          :placeholder="`Número de ${title}`"
          min="0"
          v-model="numValues"
        ></custom-input>
      </div>
      <thead>
        <tr>
          <th scope="col">{{ type }}</th>
          <th scope="col">Selecciona uno</th>
          <th scope="col">Descripcion</th>
        </tr>
      </thead>
      <tbody v-for="n in numValues" :key="`${title}_column_${n}`">
        <tr>
          <td :data-label="type">{{ n }}</td>
          <td data-label="Selecciona uno">
            <br />
            <br />
            <custom-select
              class="select"
              button
              @change="selected = $event"
              :selected="selected"
              :values="options"
            ></custom-select>
          </td>
          <td data-label="Descripcion">
            <textarea placeholder="Descripción opcional" />
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</template>

<script>
import customSelect from "@/components/Select";
import customInput from "@/components/CustomInput";

export default {
  components: { customSelect, customInput },
  props: {
    options: Array,
    numValue: Number,
    type: String,
    title: String,
  },
  data() {
    return {
      selected: 0,
      width: -1,
      numValues: 0,
    };
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
table {
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
