<template>
  <div>
      <table>
          <tr v-for="i in row" :key="i+'columna'" >
              <td v-for="n in col " :key="i+n">
                   <input :id="i+'-'+n" type="radio">
                    <label :class="{ blanco: false}" :for="i+'-'+n">{{n}}</label>
              </td>
          </tr>
          <tr v-if="last">
              <td v-for="j in last" :key="j+last+'ultima'">
                   <input :id="'last -'+j" type="radio">
                <label :class="{ blanco: false}" :for="'last -'+j">{{j}}</label>
              </td>
          </tr>
      </table>
  </div>
</template>

<script>
export default {
    data() {
        return {
            row: 3,
            col: 7,
            last: 4
        }
    },

}
</script>

<style lang="scss" scoped>
@import "src/css/colorSchema.scss";
input, label {
  background: $ligthGreen;
  color: #fff;
}

label:hover{
  background: $darkGreen;
}

input{
  display: none;
}

label {
  display: inline-block;
  padding: 5px;
  height: 40px;
  width: 40px;
  text-align: center;
  border: 2px;
  box-shadow: 2px 2px 4px $darkGreen;
  margin: 5px;
  line-height: 50px;
  cursor: pointer
}

@media (max-width: 768px) {
  .label {
  padding: 3px;
  height: 30px;
  width: 30px;

}
}

@media (max-width: 576px) {
  .label {
  padding: 2px;
  height: 25px;
  width: 25px;

}
}

label.blanco {
  background-color: white;
  color: black;
  opacity: 0.3;

  
}

label.blanco:hover{
    opacity: 0.8;
  }
</style>