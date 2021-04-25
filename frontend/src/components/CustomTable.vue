<template>
  <div>
    <!-- Tarjeta encargada de los filtros de búsqueda -->
    <div class="busqueda">
      <div class="button">
        <!-- Botón para mostrar los filtros -->
        <custom-button @click="filtros = !filtros">
          Filtros disponibles
        </custom-button>
        <!-- Botón para limpiar los filtros -->
        <custom-button @click="limpiarFiltros()">
          Limpiar filtros
        </custom-button>
      </div>

      <!-- Div con la transición para mostrar los filtros -->
      <transition name="fade">
        <div class="filtros" v-if="filtros">
          <custom-input v-model="buscador" placeholder="Nombre cabezal" />
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

          <custom-button @click="getData();getCountData()">
          Buscar
        </custom-button>

          <!-- Menú especial para versión mobil, donde además nos permite ordenar las tarjetas -->
          <h3 class="mobileSort">Ordenar por:</h3>
          <div class="mobileSort">
            <custom-button v-for="value in label" :key="value+'button'" @click="sort(`${value}`)">
              {{ value.charAt(0).toUpperCase() + value.slice(1) }} 
            </custom-button>
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
            <th>
              Acciones
            </th>
          </tr>
          
        </thead>
        <!-- Creamos columnas dinámicamente -->
        <tr v-for="(object, index) in data" :key="index">
          <td
            v-for="(value, key) in label"
            :key="value + key"
            :data-label="key"
          >
            {{ object[key.charAt(0).toLowerCase() + key.slice(1)] }} 
          </td>
          <td class="acciones">
            <div class="action">
              <custom-button @click="getData();getCountData()">
              Acceder
            </custom-button>
            <custom-button @click="openEdit(object)">
              Editar
            </custom-button>
            </div>
          </td>
        </tr>
      </table>
    </div>

    <!-- Menu de paginación -->
    <div class="page">
      <custom-button @click="prevPage">Anterior</custom-button>
      <span>- {{ currentPage }} -</span>
      <custom-button @click="nextPage">Siguiente</custom-button>
    </div>

    <modal v-if="showEdit">
        <edit-cabezal :name="value"></edit-cabezal>
    </modal>
  </div>
</template>

<script>
import CustomButton from "@/components/CustomButton";
import CustomInput from "@/components/CustomInput";
import modal from "@/components/Modal";
import editCabezal from "@/components/Modals/EditCabezal"
export default {
  components: {
    CustomButton,
    CustomInput,
    modal,
    editCabezal
  },
  props: {
    pageSize: {
      type: Number,
      required: true
    },
    label: Object
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
    data(){
      // return this.$store.state.userInfo;
      return [
        {
          id: 1356434634,
          nombre: "Cabezal 1",
          fecha: "12/12/2020 12:12:12"
        },
        {
          id: 2346346346,
          nombre: "Cabezal 2",
          fecha: "12/12/2020 12:22:12"
        },
        {
          id: 3346346343,
          nombre: "Cabezal 3",
          fecha: "12/12/2020 12:32:12"
        },
        {
          id: 412321346,
          nombre: "Cabezal 4",
          fecha: "12/12/2020 12:42:12"
        },
        {
          id: 5,
          nombre: "Cabezal 5",
          fecha: "15/12/2020 12:12:12"
        }
      ]
    },
    size(){
      return this.$store.state.countUserInfo;
    }
  },
  methods: {
    openEdit(object){
      console.log(object.nombre)
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
      if (this.currentPage * this.pageSize < this.size) {
        this.currentPage++;
        this.getData();
      }
    },
    prevPage: function () {
      if (this.currentPage > 0){
        this.currentPage--;
        this.getData();
      } ;
    },
    // Vaciamos todos los filtros
    limpiarFiltros() {
      this.dateStart = this.dateEnd = this.proyecto;
      this.getData();
      this.getCountData();
    },
    async getData(){
     //TODO: llamada a vuex, para llamar a la api
    },
    async getCountData(){
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

.page, .table {
  background: $white;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid;
  margin: 10px 50px;
  border-radius: 5px;
  box-shadow: $gray 0px 14px 28px, $gray 0px 10px 10px;
}

.acciones{
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
    table-layout: fixed;
    td {
      border-right: 1px solid $white;
      font-size: 18px;
      width: auto;

      .action{
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

    td:last-child{
      width: 10px;
    }
    td:first-child{
      width: 10px;
    }

    thead {
      th {
        color: $white;
        text-shadow: 1px;
        background: $primary;
        text-transform: uppercase;
        user-select: none;
        cursor: pointer;
        text-shadow: 3px;
      }
      th:nth-child(odd) {
        color: $white;
        background: $secondary;
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
  .action{
     flex-direction: column;
  }
}

// Ajustamos la vista para tamaños más pequños (tablet)
@media (max-width: 768px) {
  .table,
  .busqueda,
  .page  {
    margin: 10px 35px;
  }
}

// Ajustamos la vista para tamaños aun más pequeños (moviles), y cambiamos diseño de la tabla
@media (max-width: 680px) {
  .filtros {
    flex-direction: column;
  }

  .busqueda,
  .page  {
    margin: 10px 15px;
  }

  .table {
    margin: 25px 30px 30px;

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
        border-bottom: 3px solid $white;
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