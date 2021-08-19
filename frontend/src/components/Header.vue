<template>
  <div class="header">
    <h1>{{ name }}</h1>
    <div v-if="tour" class="ayuda">
      <a @click.prevent="$tours[tour].start()">
        <font-awesome-icon icon="info-circle" />
      </a>
    </div>
    <slot></slot>
  </div>
</template>

<script>
export default {
  props: {
    name: String,
    tour: String,
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
  font-size: 5vw;
  position: relative;
}

@media screen and (min-width: 480px) {
  .header {
    font-size: 24px;
  }
}

@media (max-width: 480px) {
  .ayuda {
    svg {
      top: calc(50% - 0.6em) !important;
      left: calc(50% - 0.5em) !important;
    }
  }
}

.ayuda {
  position: absolute;
  bottom: -30px;
  right: 0px;
  margin: 0.15em;
  position: absolute;
  font-size: 1.2em;
  $timing: 265ms;
  $iconColor: $primary;
  $accent: $primaryDark;
  $bluefade: $secondary;
  z-index: 1000;

  @mixin transformScale($size: 1) {
    transform: scale($size);
    -ms-transform: scale($size);
    -webkit-transform: scale($size);
  }

  svg {
    color: $white;
    position: absolute;
    top: 6px;
    left: 5px;
    transition: all $timing ease-out;
    fill: none;
    stroke: #646464;
    stroke-width: 1px;
    stroke-dasharray: 2, 2;
    stroke-linejoin: round;
  }

  a {
    display: inline-block;
    padding: 0px;
    &:before {
      @include transformScale();
      content: " ";
      width: 40px;
      height: 40px;
      border-radius: 100%;
      display: block;
      background: linear-gradient(45deg, $iconColor, $accent);
      transition: all $timing ease-out;
    }

    &:hover:before {
      transform: scale(0);
      transition: all $timing ease-in;
    }

    &:hover svg {
      @include transformScale(2.2);
      color: $white;
      -webkit-text-fill-color: transparent;
      transition: all $timing ease-in;
    }
  }
}
</style>
