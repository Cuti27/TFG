<template>
  <div class="addProgramador">
    <section class="addProgramador" id="addProgramador">
      <header>
        <h2>Genhidro</h2>
        <h3>Añadir programador de riego</h3>
      </header>
      <form action="" class="addProgramador-form">
       <login-button id="recuperar">Generar identificador para nuevo dispositivo</login-button>
       <h2 class="divider line one-line">O si ya has configurado un dispositivo</h2>
       <login-button @click="$emit('registroProgramador')" id="registro">Registro programador</login-button>
        <div class="submit-container">
          <login-button @click="close()">Cancelar</login-button>
        </div>
      </form>
    </section>
  </div>
</template>

<script>
import loginButton from "@/components/LoginButton";
export default {
  components: {
    loginButton,
  },
  methods:{
      close(){
          this.$parent.$emit('close');
      }
  }
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.divider {
  display: flex;
  
  &:before,
  &:after {
    content: "";
    flex: 1;
  }
}

.line {
  align-items: center;
  margin: 1em -1em;
  
  &:before,
  &:after {
    height: 1px;
    margin: 0 1em;
  }
}

.one-line {
    &:before,
    &:after {
      background: black;
      min-width: 40px;
    }
  }

/* Animation Keyframes */
@keyframes scale_header {
  0% {
    max-height: 0px;
    margin-bottom: 0px;
    opacity: 0;
  }
  100% {
    max-height: 117px;
    margin-bottom: 25px;
    opacity: 1;
  }
}

@keyframes input_opacity {
  0% {
    transform: translateY(-10px);
    opacity: 0;
  }
  100% {
    transform: translateY(0px);
    opacity: 1;
  }
}

@keyframes text_opacity {
  0% {
    color: transparent;
  }
}

@keyframes error_before {
  0% {
    height: 5px;
    background: rgba(0, 0, 0, 0.156);
    color: transparent;
  }
  10% {
    height: 117px;
    background: #ffffff;
    color: #c62828;
  }
  90% {
    height: 117px;
    background: #ffffff;
    color: #c62828;
  }
  100% {
    height: 5px;
    background: rgba(0, 0, 0, 0.156);
    color: transparent;
  }
}

#recuperar{
    margin-top: 20px;
}


.addProgramador {
  position: relative;
  width: 100%;
  padding: 10px;
  margin: 0 0 10px 0;
  box-sizing: border-box;
  border-radius: 25px;
  background: #fafafa;
  overflow: hidden;
  animation: input_opacity 0.2s cubic-bezier(0.55, 0, 0.1, 1);
  box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12),
    0 3px 1px -2px rgba(0, 0, 0, 0.2);
}

.addProgramador > header {
  position: relative;
  width: 100%;
  padding: 10px;
  margin: -10px -10px 25px -10px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  background: linear-gradient(to right, $primary, $secondary);
  font-family: "Roboto", sans-serif;
  font-size: 1.3rem;
  color: #fafafa;
  animation: scale_header 0.6s cubic-bezier(0.55, 0, 0.1, 1),
    text_opacity 1s cubic-bezier(0.55, 0, 0.1, 1);
  box-shadow: 0px 2px 2px 0px rgba(0, 0, 0, 0.14),
    0px 1px 5px 0px rgba(0, 0, 0, 0.12), 0px 3px 1px -2px rgba(0, 0, 0, 0.2);
}

.addProgramador > header:before {
  content: "";
  display: flex;
  justify-content: center;
  align-items: center;
  position: absolute;
  width: 100%;
  height: 5px;
  padding: 10px;
  margin: -10px 0 0 -10px;
  box-sizing: border-box;
  background: rgba(0, 0, 0, 0.156);
  font-family: "Roboto", sans-serif;
  font-size: 0.9rem;
  color: transparent;
  z-index: 5;
}

.addProgramador.error_1 > header:before,
.addProgramador.error_2 > header:before {
  animation: error_before 3s cubic-bezier(0.55, 0, 0.1, 1);
}

.addProgramador.error_1 > header:before {
  content: "Invalid username or password!";
}

.addProgramador.error_2 > header:before {
  content: "Invalid or expired Token!";
}

.addProgramador > header h2 {
  margin: 50px 0 10px 0;
}

.addProgramador > header h3 {
  font-size: 0.7em;
  animation: text_opacity 1.5s cubic-bezier(0.55, 0, 0.1, 1);
  color: rgba(255, 255, 255, 0.4);
}

/* Form */
.addProgramador-form {
  padding: 15px;
  box-sizing: border-box;
  width: 95%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;

  a{
      margin-top: 10px;
  }
}

/* Submit Button */
.submit-container {
  display: flex;
  flex-direction: row;
  justify-content: flex-end;
  position: relative;
  padding: 10px;
  margin: 15px -25px -25px -25px;
}
</style>