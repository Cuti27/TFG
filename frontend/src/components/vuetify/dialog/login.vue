<template>
  <v-dialog @submit="login()" :show="show" btnText="Login" cancelText="Cancelar" titleText="Entrar en Genhidro" submitText="Entrar">
    <form action="" class="login-form px-10">
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
      <v-spacer></v-spacer>
      <v-btn class="mt-5" @click="$emit('registro')" id="registro">Registrate</v-btn>
    </form>
  </v-dialog>
</template>

<script>
import vDialog from "@/components/vuetify/dialog";
export default {
  props: {
    show: Boolean
  },
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
    login(){
      console.log("Realizar login");
    }
  },
};
</script>

<style lang="scss" scoped></style>
