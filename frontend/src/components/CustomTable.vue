<template>
  <div class="customTable">
    <!-- Tarjeta encargada de los filtros de búsqueda -->
    <div class="busqueda">
      <div class="button">
        <!-- Botón para mostrar los filtros -->
        <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5" @click="filtros = !filtros">
          Filtros disponibles
        </v-btn>
        <!-- Botón para limpiar los filtros -->
        <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5" @click="limpiarFiltros()">
          Limpiar filtros
        </v-btn>
      </div>

      <!-- Div con la transición para mostrar los filtros -->
      <transition name="fade">
        <div class="filtros" v-if="filtros">
          <custom-input v-model="buscador" placeholder="Nombre a buscar" />
          <custom-input
            v-model="dateStart"
            :max="dateEnd"
            placeholder="Inicio"
            type="date"
          />
          <custom-input
            v-model="dateEnd"
            :min="dateStart"
            placeholder="Fin"
            type="date"
          />

          <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5"
            @click="
              getData();
              getCountData();
            "
          >
            Buscar
          </v-btn>

          <!-- Menú especial para versión mobil, donde además nos permite ordenar las tarjetas -->
          <h3 class="mobileSort">Ordenar por:</h3>
          <div class="mobileSort">
            <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5"
              v-for="value in label"
              :key="value + 'button'"
              @click="sort(`${value}`)"
            >
              {{ value.charAt(0).toUpperCase() + value.slice(1) }}
            </v-btn>
          </div>
        </div>
      </transition>
    </div>
    <!-- Tabla con las respuestas obtenidas de los filtros -->
    <div class="table">
      <p>{{ size }} elementos encontrados</p>
      <table>
        <!-- Head de la tabla, en caso de que la mostremos, nos permitirá ordenar la tabla -->
        <thead>
          <tr>
            <th v-for="(value, key) in label" :key="key" @click="sort(key)">
              {{ value }}
            </th>
            <th>Acciones</th>
          </tr>
        </thead>
        <!-- Creamos columnas dinámicamente -->
        <tr v-for="(object, index) in data" :key="index">
          <td
            v-for="(value, key) in label"
            :key="value + key"
            :data-label="key"
          >
            <day-selector
              v-if="key == 'Dias'"
              :disabled="true"
              :dias="object[value]"
            ></day-selector>
            <p v-else>{{ object[value] }}</p>
          </td>
          <td class="acciones">
            <div v-if="!remove" class="action">
              <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5"
                @click="
                  getData();
                  getCountData();
                "
              >
                Acceder
              </v-btn>
              <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5" @click="openEdit(object)"> Editar </v-btn>
            </div>
            <div v-else class="action">
              <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5">Eliminar</v-btn>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <!-- Menu de paginación -->
    <div class="page">
      <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5" @click="prevPage">Anterior</v-btn>
      <span>- {{ currentPage }} -</span>
      <v-btn color="primary"
        elevation="5"
        outlined
        rounded class="ma-5" @click="nextPage">Siguiente</v-btn>
    </div>

    <modal v-if="showEdit">
      <edit-cabezal :name="value"></edit-cabezal>
    </modal>
  </div>
</template>

<script>
import CustomInput from "@/components/CustomInput";
import modal from "@/components/Modal";
import editCabezal from "@/components/Modals/EditCabezal";
import daySelector from "@/components/DaySelector";

export default {
  components: {
    CustomInput,
    modal,
    editCabezal,
    daySelector,
  },
  props: {
    pageSize: {
      type: Number,
      required: true,
    },
    label: Object,
    remove: Boolean,
    countVuex: String,
    infoVuex: String,
  },
  data() {
    return {
      currentSort: "", // Indica el parámetro por el que ordenamos la tabla
      currentSortDir: "asc", // Indicamos si es ascendente o descendente
      currentPage: 0, // Página actual
      buscador: "", // Texto escrito en el friltro del proyecto
      filtros: false, // Booleano para mostrar o no el menu de los filtros
      dateStart: "", // Texto que indica una fecha escrita en el filtro
      dateEnd: "", // Texto que indica una fecha escrita en el filtro
      showEdit: false,
      value: "",
    };
  },

  created() {
    this.getData();
    this.getCountData();
  },
  computed: {
    data() {
      return this.$store.state[this.infoVuex];
    },
    size() {
      return this.$store.state[this.countVuex];
    },
  },
  methods: {
    openEdit(object) {
      console.log(object.nombre);
      this.value = object.nombre;
      this.showEdit = true;
    },
    sort(s) {
      //if s == current sort, reverse
      if (s === this.currentSort) {
        this.currentSortDir = this.currentSortDir === "asc" ? "desc" : "asc";
      }
      this.currentSort = s;

      // TODO: Realizar ordenación o filtrado
      this.getData();
    },
    // Funciones para avanzar y retroceder una página de la tabla
    nextPage: function () {
      if (this.currentPage + 1 <= this.size / this.pageSize) {
        this.currentPage++;
        this.getData();
      }
    },
    prevPage: function () {
      if (this.currentPage > 0) {
        this.currentPage--;
        this.getData();
      }
    },
    // Vaciamos todos los filtros
    limpiarFiltros() {
      this.dateStart = this.dateEnd = this.proyecto;
      this.getData();
      this.getCountData();
    },
    async getData() {
      //TODO: llamada a vuex, para llamar a la api
    },
    async getCountData() {
      //TODO: llamada a vuex, para llamar a la api
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.busqueda {
  border: 1px solid;
  margin: 10px 50px;
  border-radius: 5px;
  box-shadow: $gray 0px 14px 28px, $gray 0px 10px 10px;
  background: $white;
  // Centramos todos los elementos
  .button,
  .filtros {
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .mobileSort {
    display: none;
  }
}

.page,
.table {
  background: $white;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid;
  margin: 10px 50px;
  border-radius: 5px;
  box-shadow: $gray 0px 14px 28px, $gray 0px 10px 10px;
}

.acciones {
  display: flex;
}

// Creamos el diseño de la tabla principal
.table {
  // Espaciado del componente
  margin: 35px 70px 70px;
  box-shadow: 0px 35px 50px $black;
  flex-direction: column;
  // Formateo de la tabla
  table {
    border-radius: 5px;
    font-size: 12px;
    font-weight: normal;
    border: none;
    border-collapse: collapse;
    width: 100%;
    max-width: 100vw;
    background-color: white;
    td {
      border-right: 1px solid $white;
      font-size: 18px;
      width: auto;

      .action {
        display: flex;
        align-items: center;
        justify-content: center;
      }
    }
    td,
    th {
      text-align: left;
      padding: 8px;
    }

    thead {
      th {
        color: $white;
        text-align: center;
        background: darken($primary, 10);
        text-transform: uppercase;
        user-select: none;
        cursor: pointer;
        font-size: 13px;
      }
      th:nth-child(odd) {
        color: $white;
        background: darken($secondary, 10);
      }
      th:nth-child(even):hover {
        background: $primaryDark;
      }
      th:nth-child(odd):hover {
        background: $secondaryDark;
      }
    }
  }
}

@media (max-width: 1280px) {
  .action {
    flex-direction: column;
  }
}

// Ajustamos la vista para tamaños más pequños (tablet)
@media (max-width: 768px) {
  .table,
  .busqueda,
  .page {
    margin: 10px 35px;
  }
}

// Ajustamos la vista para tamaños aun más pequeños (moviles), y cambiamos diseño de la tabla
@media (max-width: 916px) {
  .filtros {
    flex-direction: column;
  }

  .busqueda,
  .page {
    margin: 10px 15px;
  }

  .table {
    margin: 25px 30px 30px;

    .acciones {
      flex-direction: column;
    }

    table {
      border: 0;
      table-layout: fixed;
      border-collapse: collapse;
      width: 100%;
      padding: 0px;
      margin: 0px;
      thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;

        padding: 0;
        position: absolute;
        width: 1px;
      }
      tr {
        border-bottom: 3px solid $primary;
        display: block;
        margin-bottom: 0.625em;
      }
      td {
        border-bottom: 1px solid $white;
        display: block;
        font-size: 0.8em;
        text-align: right;
        min-height: 28px;
      }
      td::before {
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
        padding-right: 5px;
      }
      td:last-child {
        border-bottom: 0;
      }
    }
  }

  // Hacemos aparacer la botonera
  .busqueda .mobileSort {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
  }
}
</style>
