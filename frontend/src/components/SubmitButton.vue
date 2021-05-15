<template>
  <div @click="$emit('click')" class="boton">
    <a><slot></slot></a>
  </div>
</template>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";
.boton {
  display: inline;
  cursor: pointer;
  background: $white;
  box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
  a {
    background: $white;
    cursor: pointer;
    transform: translate(-0%, -0%);
    color: $primary;
    text-decoration: none;
    font-size: 1.3em;
    display: inline-block;
    text-transform: uppercase;
    padding: 0.5em 2em;
    border: 2px solid $primary;
    transition: 0.02s 0.2s cubic-bezier(0.1, 0, 0.1, 1);
    &::before {
      content: "";
      display: inline-block;
      position: absolute;
      top: 0;
      left: 0;
      right: 100%;
      bottom: 0;
      background: $primary;
      transition: 0.3s 0.2s cubic-bezier(0.1, 0, 0.1, 1),
        left 0.3s cubic-bezier(0.1, 0, 0.1, 1);
      z-index: -1;
    }
    &::after {
      content: "";
      display: inline-block;
      background-image: url("https://image.flaticon.com/icons/png/128/109/109617.png");
      position: absolute;
      top: 0;
      left: calc(100% - 3em);
      right: 3em;
      bottom: 0;
      background-size: 1.5em;
      background-repeat: no-repeat;
      background-position: center;
      transition: right 0.3s cubic-bezier(0.1, 0, 0.1, 1);
    }
    &:hover {
      padding: 0.5em 3.5em 0.5em 0.5em;
      &::before {
        left: calc(100% - 3em);
        right: 0;
        transition: 0.3s cubic-bezier(0.1, 0, 0.1, 1),
          left 0.3s 0.2s cubic-bezier(0.1, 0, 0.1, 1);
      }
      &::after {
        right: 0;
        transition: right 0.3s 0.2s cubic-bezier(0.1, 0, 0.1, 1);
      }
    }
  }
}
</style>
