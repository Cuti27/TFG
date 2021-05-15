<template>
  <!-- <div class="login">
    <section class="login" id="login">
      <header>
        <h2>Genhidro</h2>
        <h3>Login</h3>
      </header>
      <form action="" class="login-form">
        <custom-input type="text" placeholder="Username"></custom-input>
        <custom-input type="password" placeholder="Contraseña"></custom-input>
        <login-button id="recuperar">Has olvidado la contraseña?</login-button>
        <login-button @click="$emit('registro')" id="registro"
          >Registrate</login-button
        >
        <div class="submit-container">
          <login-button @click="close()">Cancelar</login-button>
          <login-button>Entrar</login-button>
        </div>
      </form>
    </section>
  </div> -->
  <v-dialog btnText="Login" cancelText="Cancelar" titleText="Entrar en Genhidro">
    <form action="" class="login-form">
      <v-text-field
        label="Usuario"
        :rules="rulesUser"
        hide-details="auto"
      ></v-text-field>
      <v-text-field
        v-model="password"
        :append-icon="show1 ? 'fas fa-eye' : 'fas fa-eye-slash'"
        :rules="[rules.required, rules.min]"
        :type="show1 ? 'text' : 'password'"
        name="input-10-1"
        label="Contraseña"
        hint="Al menos 8 carácteres"
        counter
        @click:append="show1 = !show1"
      ></v-text-field>
      <v-btn id="recuperar">Has olvidado la contraseña?</v-btn>
      <v-btn @click="$emit('registro')" id="registro">Registrate</v-btn>
      <div class="submit-container">
        <v-btn @click="close()">Cancelar</v-btn>
        <v-btn>Entrar</v-btn>
      </div>
    </form>
  </v-dialog>
</template>

<script>
import vDialog from "@/components/vuetify/dialog";
export default {
  components: {
    vDialog,
  },
  data() {
    return {
      rulesUser: [
        (value) => !!value || "Obligatorio",
        (value) => (value && value.length >= 3) || "Min 3 caracteres",
      ],
      rules: {
        required: (value) => !!value || "Obligatorio.",
        min: (v) => v.length >= 8 || "Min 8 caracteres",
      },
      show1: false,
      password: "",
    };
  },
  methods: {
    close() {
      this.$parent.$emit("close");
    },
  },
};
</script>

<style lang="scss" scoped></style>
