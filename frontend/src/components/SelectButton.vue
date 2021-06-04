<template>
  <div class="middle">
    <label v-for="(element, index) in options" :key="element">
      <input
        @input="$emit('input', index)"
        type="radio"
        :name="name"
        :checked="selected == index"
      />
      <div class="front-end box">
        <span :style="{ top: xl ? '-63px' : '-55px' }">{{ element }}</span>
      </div>
    </label>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selected: this.sel ? this.sel : 0,
    };
  },
  props: {
    options: Array,
    name: String,
    xl: Boolean,
    sel: Number,
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

$green: linear-gradient($secondary, $secondaryDark);
.middle {
  width: 100%;
  text-align: center;

  input[type="radio"] {
    display: none;
    &:checked {
      + .box {
        opacity: 1;
        background: $green;
        box-shadow: $primaryDark 0px 20px 30px -18px;
        transition: box-shadow 0.5s ease-in-out;
        span {
          color: white;
          // transform: translateY(70px);
          &:before {
            // transform: translateY(0px);
            opacity: 1;
          }
        }
      }
    }
  }
  .box {
    width: 130px;
    height: 50px;
    background-color: $white;
    opacity: 0.7;
    transition: all 250ms ease;
    will-change: transition;
    display: inline-block;
    text-align: center;
    cursor: pointer;
    position: relative;
    border: 1px solid;
    border-radius: 25px;
    font-weight: 600;
    margin-left: 5px;
    &:active {
      border: 0px;
      // transform: translateY(10px);
    }
    span {
      position: absolute;
      transform: translate(0, 67px);
      left: 0;
      right: 0;
      // top: -66px;
      transition: all 300ms ease;
      font-size: 0.9em;
      user-select: none;
      color: $green;

      &:before {
        font-size: 1em;
        font-family: FontAwesome;
        display: block;
        transform: translateY(-80px);
        opacity: 0;
        transition: all 300ms ease-in-out;
        font-weight: normal;
        color: white;
      }
    }
  }
}
</style>
