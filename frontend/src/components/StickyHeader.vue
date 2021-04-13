<template>
  <header :class="{ headerShrink: visible }">
    <slot></slot>
  </header>
</template>

<script>
//TODO: Hay que arreglarlo si al final se va a usar
export default {
  data() {
    return {
      visible: true,
    };
  },
  methods: {
    scrollListener() {
      this.visible = window.scrollY > 50;
    },
  },
  mounted() {
    window.addEventListener("scroll", this.scrollListener);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.scrollListener);
  },
};
</script>

<style lang="scss" scoped>
header {
  border-color: transparent;
  background-color: #fff;
  border-bottom: 1px solid #aaaaaa;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 25px;
  position: fixed;
  right: 0;
  left: 0;
  z-index: 1030;
  min-height: 50px;
  transition: padding 0.3s;
  .headerShrink{
      padding: 0px;
  }
}
</style>