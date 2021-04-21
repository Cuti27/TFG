<template>
  <div class="login">
      <div>
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
      </div>
  </div>
</template>

<script>
import customInput from "@/components/CustomInput";
import loginButton from "@/components/LoginButton";
export default {
    components: {
        customInput,
        loginButton
    }
}
</script>

<style>

</style>