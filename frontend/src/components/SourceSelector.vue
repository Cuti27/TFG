<template>
  <div class="sourceList">
    <slot></slot>
    <div v-for="(item, index) in options" :key="item + index">
      <input :id="item + '-' + index" type="radio" />
      <label :class="{ blanco: false }" :for="item + '-' + index">{{
        item
      }}</label>
    </div>
  </div>
</template>

<script>
//TODO: Definir si debemos poder poner muchas fuentes o únicamente 4
export default {
  props: {
    options: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      check: true,
    };
  },
};
</script>

<style lang="scss" scoped>
@import "/src/css/colorSchema.scss";

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
  display: inline-block;
  padding: 5px;
  height: 50px;
  text-align: center;
  border: 2px;
  box-shadow: 2px 2px 4px $darkGreen;
  margin: 5px;
  line-height: 50px;
  cursor: pointer;
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

label.blanco:hover {
  opacity: 0.8;
}

.sourceList {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  flex-wrap: 1;
}
</style>