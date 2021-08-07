<template>
  <div class="dayList">
    <slot></slot>
    <div
      v-for="(day, index) in days"
      :key="index"
      @click.prevent="togleValue(index)"
    >
      <input :disabled="disabled" :id="day + '-' + index" type="radio" :checked="daysValue[index]" />
      <label
        :class="{ blanco: !daysValue[index], xs, disabled }"
        :for="day + '-' + index"
        >{{ day }}</label
      >
    </div>
  </div>
</template>

<script>
export default {
  props: {
    disabled: Boolean,
    dias: Array,
    xs: {
      type: Boolean,
    },
  },
  data() {
    // Creamos un array para comprobar el día
    return { days: ["L", "M", "X", "J", "V", "S", "D"] };
  },
  methods: {
    // Llamamos a la actualización del indice
    togleValue(index) {
      // this.daysValue[index] = !this.daysValue[index];
      if (!this.disabled) this.$store.dispatch("updateDays", index);
    },
  },
  // Recuperamos el valor
  computed: {
    daysValue() {
      //console.log(this.$store.getters.programDays)
      if (this.dias) return this.dias;
      return this.$store.getters.programDays;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "src/css/colorSchema.scss";

input,
label {
  background: $primaryDark;
  color: #fff;
  transition: background 0.3s;
}

label:hover {
  background: $primary;
}

input {
  display: none;
}

label {
  display: inline-block;
  width: 50px;
  border-radius: 50%;
  height: 50px;
  text-align: center;
  border: 2px;
  box-shadow: 2px 2px 4px $darkGreen;
  margin: 5px;
  line-height: 50px;
  cursor: pointer;
  transition: all 0.5s ease;

  &:hover{
    transform: translateY(-5px);
    box-shadow: 0 4px 25px 0 rgba(34,41,47,.25);
  }
}

.xs {
  width: 25px;
  border-radius: 50%;
  height: 25px;
  line-height: 25px;
}

label.blanco {
  background-color: $white;
  color: $black;
  opacity: 0.5;
}

label.blanco:hover {
  opacity: 0.8;
}

.dayList {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  flex-wrap: 1;
}

.disabled{
  text-decoration: line-through;
  color: rgba(200,200,200, 0.5);
  background: $primaryShadow;

  &.blanco{
    color: rgba(0,0,0, 0.5);
    background: rgba(200,200,200,0.5)
  }

  &:hover{
        transform: none;
        box-shadow: 0;
  }
}
</style>
