<template>
  <div class="flip-card">
    <button @click="show = !show">Dar la vuelta</button>
    <transition name="fade" mode="out-in">
      <div v-if="show" key="table">
        <table>
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
        </table>
      </div>

      <div v-else key="map">
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Iste, vero,
          ipsa veritatis nihil natus beatae expedita quasi quisquam voluptatum,
          dignissimos molestias quo numquam quod in non aliquam velit sint
          sequi. Libero, ab odio? Nemo explicabo iste illum eum voluptates
          aperiam? Consequatur, optio ipsum impedit, minima sed eaque unde
          perferendis dicta quas voluptatum quis deserunt et amet
          exercitationem, fuga maiores consequuntur? Aut nesciunt excepturi
          illum illo voluptatibus eum cum et sapiente ea sunt? Distinctio ipsam
          non tempora!
        </p>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
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



table {
  border-collapse: separate;
  border-spacing: 5px 15px;
}

input,
label {
  background: $ligthGreen;
  color: #fff;
}

label:hover {
  background: $darkGreen;
}

input {
  display: none;
}

label {
  display: float;
  padding: 20px;
  height: 40px;
  width: 40px;
  text-align: center;
  border: 2px;
  box-shadow: 2px 2px 4px $darkGreen;
  margin: 10px;
  line-height: 50px;
  cursor: pointer;
  user-select: none;
}

label.blanco {
  background-color: white;
  color: black;
  opacity: 0.3;
}

label.blanco:hover {
  opacity: 0.8;
}

@media (max-width: 768px) {
  table {
    border-collapse: collapse;
    border-spacing: 0px 7px;
  }
  label {
    padding: 15px;
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
  }
}
</style>