<template>
  <div class="login">
    <!-- <div>
          <div class="header">
              <h3>Bienvenido al programa de riego de <span>Genhidro</span></h3>
          </div>
          <div class="body">
            <custom-input type="text" placeholder="Username"></custom-input>
            <custom-input type="password" placeholder="Contraseña"></custom-input>
          </div>
          <div class="footer">
              <login-button>Cancelar</login-button>
              <login-button>Login</login-button>
          </div>
      </div> -->
    <section class="login" id="login">
      <header>
        <h2>Genhidro</h2>
        <h3>Login</h3>
      </header>
      <form action="" class="login-form">
        <custom-input type="text" placeholder="Username"></custom-input>
        <custom-input type="password" placeholder="Contraseña"></custom-input>
       <login-button id="recuperar">Has olvidado la contraseña?</login-button>
        <div class="submit-container">
          <login-button @click="close()">Cancelar</login-button>
          <login-button>Entrar</login-button>
        </div>
      </form>
    </section>
  </div>
</template>

<script>
import customInput from "@/components/CustomInput";
import loginButton from "@/components/LoginButton";
export default {
  components: {
    customInput,
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

/* Login Form */
.login-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
  width: 340px;
  height: auto;
  padding: 5px;
  box-sizing: border-box;
}


.login-container p {
  align-self: flex-start;
  font-family: "Roboto", sans-serif;
  font-size: 0.8rem;
  color: rgba(0, 0, 0, 0.5);
}

.login-container p a {
  color: rgba(0, 0, 0, 0.4);
}

.login {
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

.login > header {
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

.login > header:before {
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

.login.error_1 > header:before,
.login.error_2 > header:before {
  animation: error_before 3s cubic-bezier(0.55, 0, 0.1, 1);
}

.login.error_1 > header:before {
  content: "Invalid username or password!";
}

.login.error_2 > header:before {
  content: "Invalid or expired Token!";
}

.login > header h2 {
  margin: 50px 0 10px 0;
}

.login > header h3 {
  font-size: 0.7em;
  animation: text_opacity 1.5s cubic-bezier(0.55, 0, 0.1, 1);
  color: rgba(255, 255, 255, 0.4);
}

/* Form */
.login-form {
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