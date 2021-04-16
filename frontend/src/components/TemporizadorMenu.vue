<template>
  <div class="temporizadores">
    <temporizador
      v-for="(temp, index) in temporizadores"
      :key="'Temporizador' + index"
      v-model="temporizadores[index]"
      :title="index == 0"
      @click="remove($event)"
      :id="index"
    >Temporizador {{ index+1 }}</temporizador>
    <a @click.prevent="add()" :class="{ button: true, success }" href="#" role="button">
      <span>Añadir</span>
      <div class="icon">
        <font-awesome-icon v-if="!success" icon="plus-square" size="3x" />
        <font-awesome-icon v-else icon="check" size="3x" />
      </div>
    </a>
  </div>
</template>

<script>
import Temporizador from "@/components/Temporizador";
export default {
  components: {
    Temporizador,
  },
  data() {
    return {
      temporizadores: [[]],
      success: false,
    };
  },
  methods: {
    add() {
      this.success = true;
      this.temporizadores.push([]);
       setTimeout(() => this.success = false, 1000);
    },
    remove(event){
        console.log(event)
        if(this.temporizadores.length >= 2)
            this.temporizadores.splice(event - 1,1);
    }
  },
};
</script>

<style lang="scss">
@import "@/css/colorSchema.scss";

// Variables
$speed: "0.25s";
$transition: all #{$speed} cubic-bezier(0.31, -0.105, 0.43, 1.4);

.temporizadores {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
}

/* Main Styles */
.button {
  display: block;
  background-color: $primary;
  width: 300px;
  height: 100px;
  line-height: 100px;
  margin: auto;
  margin-top: 20px;
  color: #fff;
  position: relative;
  margin-right: 100px;
  margin-left: 100px;
  cursor: pointer;
  border-radius: 25px;
  box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.3);
  transition: $transition;

  span,
  .icon {
    display: block;
    height: 100%;
    text-align: center;
    position: absolute;
    top: 0;
  }

  span {
    width: 72%;
    line-height: inherit;
    font-size: 22px;
    text-transform: uppercase;
    left: 0;
    transition: $transition;

    &:after {
      content: "";
      background-color: $primaryDark;
      width: 2px;
      height: 70%;
      position: absolute;
      top: 15%;
      right: -1px;
    }
  }

  .icon {
    width: 28%;
    right: 0;
    transition: $transition;
    top: 10px;

    .fa {
      font-size: 30px;
      vertical-align: middle;
      transition: $transition, height #{$speed} ease;
    }

    .fa-remove {
      height: 36px;
    }

    .fa-check {
      display: none;
    }
  }

  &.success,
  &:hover {
    span {
      left: -72%;
      opacity: 0;
    }

    .icon {
      width: 100%;

      .fa {
        font-size: 45px;
      }
    }
  }

  &.success {
    background-color: $secondary;

    .icon {
      .fa-remove {
        display: none;
      }

      .fa-check {
        display: inline-block;
      }
    }
  }

  &:hover {
    opacity: 0.9;

    .icon .fa-remove {
      height: 46px;
    }
  }

  &:active {
    opacity: 1;
  }
}
</style>