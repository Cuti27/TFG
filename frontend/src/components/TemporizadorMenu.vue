<template>
  <div class="temporizadores">
    <temporizador
    :class="{disabled: disabled, remove: removing == index, creando: success && temporizadores.length == index + 1}" 
      v-for="(temp, index) in temporizadores"
      :key="'Temporizador' + getHash(index)"
      v-model="temporizadores[index]"
      :title="index == 0"
      @delete="remove($event)"
      :id="index"
      :value="temporizadores[index]"
      :disabled="disabled"
      >Temporizador {{ index + 1 }}</temporizador
    >

    <a v-if="!disabled"
      @click.prevent="add()"
      :class="{ button: true, success }"
      href="#"
      role="button"
    >
      <span>Añadir</span>
      <div class="icon" >
        <font-awesome-icon v-if="!success" icon="plus-square" size="2x" />
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
  props: {
    disabled: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      temporizadores: [
        {
          inicio: [0, 0, 0],
          duracion: [0, 0, 0],
          post: [0, 0, 0],
        },
      ],
      success: false,
      removing: -100
    };
  },
  methods: {
    add() {
      this.success = true;
      this.temporizadores.push({
          inicio: [0, 0, 0],
          duracion: [0, 0, 0],
          post: [0, 0, 0],
        });
      setTimeout(() => (this.success = false), 600);
    },
    remove(event) {
      if (this.temporizadores.length >= 2){
        this.removing = event;
        setTimeout(() => {
          this.temporizadores.splice(event, 1);
          this.removing = -100
        }, 600);
      }
        
    },
    getHash(){
      return Math.floor(Math.random() * 10000);
    }
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.disabled {
  opacity: 0.3;
}

.remove {
  -webkit-animation: 0.4s ease-in 0.2s remove; /* Safari, Chrome and Opera > 12.1 */
       -moz-animation: 0.4s ease-in 0.2s remove; /* Firefox < 16 */
        -ms-animation: 0.4s ease-in 0.2s remove; /* Internet Explorer */
         -o-animation: 0.4s ease-in 0.2s remove; /* Opera < 12.1 */
            animation: 0.4s ease-in 0.2s remove;
   animation: 0.4s ease-in 0.2s remove;
}

.creando{
  opacity: 0;
  animation: 0.4s ease-in 0.2s create;
}

@-webkit-keyframes create {
  0% { opacity: 0; transform: scale(0, 0); height: 0px; }
  99% {
    transform: scale(1.1, 1.1);
    height: auto;
  }
  100% { opacity: 1; height: auto;  }
}

@-moz-keyframes create {
  0% { opacity: 0; transform: scale(0, 0); height: 0px; }
  99% {
    transform: scale(1.1, 1.1);
    height: auto;
  }
  100% { opacity: 1; height: auto;  }
}

@-ms-keyframes create {
  0% { opacity: 0; transform: scale(0, 0); height: 0px; }
  99% {
    transform: scale(1.1, 1.1);
    height: auto;
  }
  100% { opacity: 1; height: auto;  }
}

@keyframes create {
  0% { opacity: 0; transform: scale(0, 0); height: 0px; }
  99% {
    transform: scale(1.1, 1.1);
    height: auto;
  }
  100% { opacity: 1; height: auto;  }
}

@keyframes remove {
     from {
    transform: scale(1, 1);
  }
  
  30% {
    transform: scale(1.1, 1.1);
  }

  99% {
    transform: scale(0, 0);
    height: 0;
  }
  
  to {
    height: 0;
    opacity: 0;
  }
}

/* Firefox < 16 */
@-moz-keyframes remove {
     from {
    transform: scale(1, 1);
  }
  
  30% {
    transform: scale(1.1, 1.1);
  }

  99% {
    transform: scale(0, 0);
    height: 0;
  }
  
  to {
    height: 0;
    opacity: 0;
  }
}

/* Safari, Chrome and Opera > 12.1 */
@-webkit-keyframes remove {
     from {
    transform: scale(1, 1);
  }
  
  30% {
    transform: scale(1.1, 1.1);
  }

  99% {
    transform: scale(0, 0);
    height: 0;
  }
  
  to {
    height: 0;
    opacity: 0;
  }
}

/* Internet Explorer */
@-ms-keyframes remove {
     from {
    transform: scale(1, 1);
  }
  
  30% {
    transform: scale(1.1, 1.1);
  }

  99% {
    transform: scale(0, 0);
    height: 0;
  }
  
  to {
    height: 0;
    opacity: 0;
  }
}
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
  width: 200px;
  height: 75px;
  line-height: 100px;
  margin: auto;
  margin-top: 20px;
  color: #fff;
  position: relative;
  margin-right: 50px;
  margin-left: 50px;
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
    top: -10px;
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
      top: 25%;
      right: -1px;
    }
  }

  .icon {
    width: 28%;
    right: 0;
    transition: $transition;
    top: -5px;

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

@media (max-width: 990px){
  .button {
    width: 200px;
    height: 75px;
    .icon {
      top: -2px;
    }
    span{
      top: -9px;
      &:after{
        top: 17px;
      }
    }
  }
}
@media (max-width: 576px) {
  .button {
    .icon {
      top: -5px;
    }
    span{
      top: -12px;
      &:after{
        top: 22px;
      }
    }
  }
}
</style>