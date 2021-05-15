<template>
  <v-dialog
    @submit="registro()"
    :show="show"
    btnText="Registro"
    cancelText="Cancelar"
    titleText="Registrarse en Genhidro"
    submitText="Registrate"
  >
    <form action="" class="login-form px-10">
      <v-text-field
        label="Usuario"
        :rules="rulesUser"
        hide-details="auto"
      ></v-text-field>
      <v-text-field
        label="Correo"
        :rules="rulesEmail"
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
      <v-btn id="recuperar">Ya tienes una cuenta?</v-btn>
    </form>
  </v-dialog>
</template>

<script>
import vDialog from "@/components/vuetify/dialog";
export default {
  props: {
    show: Boolean,
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
      rulesEmail: [
        (value) => {
          const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return (
            re.test(String(value).toLowerCase()) ||
            "Debe especificar un correo válido"
          );
        },
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
    registro() {
      console.log("Realizar registro");
    },
  },
};
</script>

<style lang="scss" scoped></style>
