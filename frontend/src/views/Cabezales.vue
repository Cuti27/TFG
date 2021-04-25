<template>
  <div>
      <!-- Header -->
      <header-custom name="Listado de cabezales"></header-custom>

    <div class="menu">
        <button>Añadir cabezal</button>
        <button>Eliminar cabezal</button>
    </div>
    <div class="listado">
        <custom-table :label="{Id: 'id',Nombre: 'nombre',Fecha: 'fecha' }" :pageSize="5">
      
    </custom-table>
    </div>
  </div>
</template>

<script>
import headerCustom from "@/components/Header";
import customTable from "@/components/CustomTable"

export default {
    components: {
        headerCustom,
        customTable
    },
}
</script>

<style>

</style>