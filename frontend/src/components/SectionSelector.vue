<template>
  <div class="SectionSelector">
    <toggle v-model="show"></toggle>
    <div class="content">
      <transition name="fade" mode="out-in">
        <div v-if="show" key="table">
          <table>
            <tbody>
              <tr v-for="i in row" :key="i + 'columna'">
                <td v-for="n in col" :key="i + n">
                  <input :id="i + '-' + n" type="radio" />
                  <label :class="{ blanco: false }" :for="i + '-' + n">
                    {{ n }}
                  </label>
                </td>
              </tr>
              <tr v-if="last">
                <td v-for="j in last" :key="j + last + 'ultima'">
                  <input :id="'last -' + j" type="radio" />
                  <label :class="{ blanco: false }" :for="'last -' + j">{{
                    j
                  }}</label>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="map" v-else key="map">
          <img src="../assets/map-placeholder.jpg" alt="Mapa de prueba" />
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import Toggle from "@/components/Toggle";
export default {
  components: {
    Toggle,
  },
  data() {
    return {
      row: 3,
      col: 7,
      last: 4,
      show: false,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "src/css/colorSchema.scss";

.SectionSelector {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  transition: background .3s;
  width: 100%;
  .map {
    img {
      width: 100%;
      max-width: 600px;
    }
  }
}

table {
  border-collapse: separate;
  border-spacing: 5px 15px;
  table-layout: fixed;
  width: 100%;
}

input,
label {
  background: $primaryDark;
  color: #fff;
}

label:hover {
  background: $primary;
}

input {
  display: none;
}

label {
  padding: 20px 40px;
  text-align: center;
  border: 2px;
  border-radius: 10px;
  box-shadow: 2px 2px 4px $primaryShadow;
  margin: 5px;
  line-height: 50px;
  cursor: pointer;
  user-select: none;
}

label.blanco {
  background-color: $white;
  color: $black;
  opacity: 0.3;
}

label.blanco:hover {
  opacity: 0.8;
}

@media (max-width: 768px) {
  table {
    border-collapse: collapse;
    border-spacing: 5px 7px;
  }
  label {
    padding: 15px 20px;
    height: 30px;
    width: 30px;
  }
}

@media (max-width: 576px) {
  label {
    padding: 12px;
    height: 25px;
    width: 25px;
    font-size: 15px;
    margin: 3px;
  }
}
</style>