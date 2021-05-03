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
  border-radius: 50px;
  background: linear-gradient(160deg, $primary, $secondaryDark);
  box-shadow:  20px 20px 60px $primary,
             -20px -20px 60px #ffffff;
  padding: 20px;
  margin: 20px;
  margin-bottom: 40px;
  // background: linear-gradient($primaryShadow, $secondaryShadow),
  //   url("../assets/header.jpg");
  // background-repeat: no-repeat;
  // background-attachment: fixed;
  // background-position: center;
  // background-size: cover;
  // background-position-y: -150px;
  color: $white;
  height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5em;
}
</style>