<template>
  <div class="header">
      <h1>{{ name }}</h1>
      <slot></slot>
</div>
</template>

<script>
export default {
    props: {
        name: String
    }
}
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";
.header {
  box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px,
    rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
  padding: 20px;
  margin: 20px;
  margin-bottom: 40px;
  background: linear-gradient($primaryShadow, $secondaryShadow),
    url("../assets/header.jpg");
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
  background-position-y: -150px;
  color: white;
  height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5em;
}
</style>