<template>
    <transition name="modal">
    <div class="modal-mask">
      <div class="modal-wrapper">
        <div class="modal-container">
          <slot></slot>
          <!-- <div class="modal-header">
            <slot name="header">
              default header
            </slot>
          </div>

          <div class="modal-body">
            <slot name="body">
              default body
            </slot>
          </div>

          <div class="modal-footer">
            <slot name="footer">
              
            </slot>
            <button class="modal-default-button" @click="$emit('close')">
                OK
              </button>
          </div> -->
        </div>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
  
}

.modal-container {
  width: 40vw;
  margin: 0px auto;
  padding: 20px 30px;
  border-radius: 25px;
  transition: all .3s ease;
}

@media (max-width: 768px) {
  .modal-container {
    width: 80vw;
    margin: 0px auto;
    padding: 10px 15px;
  }
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
  opacity:1;
}

.modal-leave-active .modal-container{
  -webkit-transform: scale(0);
  transform: scale(0);
  opacity: 0;
}
</style>