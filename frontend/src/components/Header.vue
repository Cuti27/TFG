<template>
  <div class="header">
    <h1>{{ name }}</h1>
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    name: String,
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";
.header {
  border-radius: 50px;
  background: linear-gradient(160deg, $primary, $primaryDark);
  box-shadow: 20px 20px 60px $primary, -20px -20px 60px #ffffff;
  padding: 20px;
  margin: 0px;
  margin-bottom: 40px;
  margin-top: 10px;
  color: $white;
  min-height: 150px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 5vw
}

@media screen and (min-width: 480px) {
  .header {
     font-size: 24px;
  }
}
</style>
