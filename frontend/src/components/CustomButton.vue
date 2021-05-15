<template>
  <button class="btn" @click.prevent="$emit('click', $event.target.value)">
    <slot></slot>
  </button>
</template>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.btn {
  box-sizing: border-box;
  appearance: none;
  background-color: transparent;
  border-radius: 0.6em;
  cursor: pointer;
  display: flex;
  align-self: center;
  font-size: 0.8rem;
  font-weight: 300;
  line-height: 1;
  margin: 10px;
  padding: 1em 2em;
  text-decoration: none;
  text-align: center;
  text-transform: uppercase;
  font-family: "Montserrat", sans-serif;
  font-weight: 700;

  &:hover,
  &:focus {
    color: $black;
    outline: 0;
  }

  border-color: $black;
  color: $black;
  background: {
    image: linear-gradient(45deg, $primary 50%, transparent 50%);
    position: 100%;
    size: 300%;
  }
  transition: background 300ms ease-in-out;

  &:hover {
    background-position: 0;
  }
}
</style>
