<template>
  <input
    name="Activo"
    type="checkbox"
    class="toggle"
    :data="data"
    @change="$emit('change', !data)"
  />
</template>

<script>
export default {
  model: {
    prop: "data",
    event: "change",
  },
  props: {
    data: Boolean,
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

input {
  margin-left: 10px;
  margin-right: 10px;
}

input[type="checkbox"] {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  -webkit-tap-highlight-color: transparent;
  cursor: pointer;
  &:focus {
    outline: 0;
  }

 
}
.toggle {
  height: 32px;
  width: 52px;
  border-radius: 16px;
  display: inline-block;
  position: relative;
  margin: 0;
  border: 2px solid #474755;
  background: linear-gradient(90deg, $primaryShadow 0%, $gray 100%);
  transition: all 0.2s ease;

  &:after {
    content: "";
    position: absolute;
    top: 2px;
    left: 2px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: $white;
    box-shadow: 2px 2px 2px rgba(44, 44, 44, 0.2);
    transition: all 0.2s cubic-bezier(0.5, 0.1, 0.75, 1.35);
  }
  &:checked {
    border-color: $primary;
    background: linear-gradient(-90deg, $primary 0%, $primaryDark 100%);;
    &:after {
      transform: translatex(20px);
    }
  }
}
</style>