<template>
  <div class="selector">
    <div class="arrow izquierda">
      <font-awesome-icon
        :class="{ button: !button }"
        icon="arrow-circle-left"
        @click="before()"
        size="2x"
      />
    </div>
    <select
      :class="{ button: button }"
      v-model="temp_value"
      name=""
      id=""
      required
    >
      <option
        @click="$emit('change', index)"
        v-for="(value, index) in values"
        :key="value + index"
        :value="index"
      >
        {{ value }}
      </option>
    </select>
    <div class="arrow">
      <font-awesome-icon
        :class="{ button: !button }"
        icon="arrow-circle-right"
        @click="next()"
        size="2x"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    values: Array,
    selected: Number,
    button: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      temp_value: this.selected,
    };
  },
  methods: {
    next() {
      this.temp_value = (this.temp_value + 1) % this.values.length;
      this.$emit("change", this.temp_value);
    },
    before() {
      this.temp_value =
        this.temp_value - 1 < 0 ? this.values.length - 1 : this.temp_value - 1;
      this.$emit("change", this.temp_value);
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.selector {
  display: flex;
  align-items: center;
  justify-content: center;

  background: none;

  select {
    cursor: pointer;
    border: none;
    text-indent: 1px;
    text-overflow: ellipsis;
    border: 1px solid;
    border-radius: 5px;
    font-size: 20px;
    padding: 10px;
    box-shadow: $primaryShadow 0px 2px 8px 0px;
    width: 100%;
    max-width:300px;
  }

  select.button {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none; /* get rid of default appearance for IE8, 9 and 10*/
  }

  .arrow {
    cursor: pointer;
    margin: auto 15px;
    color: $primaryDark;
    :hover {
      color: $primary;
    }

    .button {
      display: none;
    }
  }
}
</style>