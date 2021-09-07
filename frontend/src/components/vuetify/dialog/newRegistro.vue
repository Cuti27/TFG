<template>
  <v-dialog
    v-model="dialog"
    transition="dialog-bottom-transition"
    max-width="400"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        color="primary"
        elevation="5"
        outlined
        rounded
        :fab="!show"
        :small="!show"
        v-bind="attrs"
        v-on="on"
        ><div v-if="show">Registro <font-awesome-icon icon="user-plus" /></div>
        <font-awesome-icon v-else icon="user-plus" />
      </v-btn>
    </template>
    <template v-slot:default="dialog">
      <v-card>
        <v-toolbar color="primary" dark
          ><h2>Registrarse en Genhidro</h2></v-toolbar
        >
        <v-container class="pa-4">
          <form action="" class="login-form px-10">
            <v-text-field
              label="Usuario"
              :rules="rulesUser"
              hide-details="auto"
              v-model="name"
            ></v-text-field>
            <v-text-field
              label="Correo"
              :rules="rulesEmail"
              hide-details="auto"
              v-model="email"
            ></v-text-field>
            <v-text-field
              label="Teléfono"
              :rules="rulesPhone"
              hide-details="auto"
              v-model="phone"
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
              v-model="password_confirmation"
              :append-icon="show1 ? 'fas fa-eye' : 'fas fa-eye-slash'"
              :rules="[rules.required, rules.min]"
              :type="show1 ? 'text' : 'password'"
              name="input-10-1"
              label="Contraseña"
              hint="Al menos 8 carácteres"
              counter
              @click:append="show1 = !show1"
            ></v-text-field>
            <v-btn @click="doLogin()" id="recuperar"
              >Ya tienes una cuenta?</v-btn
            >
          </form>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog.value = false">
            Cancelar
          </v-btn>

          <v-btn color="blue darken-1" text @click="submit()">
            Registrate
          </v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      dialog: false,
      rulesUser: [
        (value) => !!value || "Obligatorio",
        (value) => (value && value.length >= 3) || "Min 3 caracteres",
      ],
      rulesEmail: [
        (value) => {
          const re =
            /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return (
            re.test(String(value).toLowerCase()) ||
            "Debe especificar un correo válido"
          );
        },
      ],
      rulesPhone: [
        (value) => !!value || "Obligatorio",
        (value) => (value && value.length >= 9) || "Número valido",
        (value) =>
          (value && value.length <= 9 && value[0] != "+") ||
          "Debes indicar el +34 (o pais correspondiente)",
      ],
      rules: {
        required: (value) => !!value || "Obligatorio.",
        min: (value) => value.length >= 8 || "Min 8 caracteres",
      },
      show1: false,
      password: "",
      password_confirmation: "",
      email: "",
      name: "",
      phone: "",
    };
  },
  computed: {
    ...mapGetters(["showLogin", "showRegistro"]),
  },
  props: {
    show: {
      type: Boolean,
      requred: false,
    },
  },
  watch: {
    dialog: function (newVal, oldVal) {
      if (newVal != oldVal) this.updateRegistro(newVal);
    },
    showLogin: function (newVal) {
      if (newVal) {
        this.dialog = false;
        this.updateRegistro(false);
      }
    },
    showRegistro: function (newVal) {
      this.dialog = newVal;
    },
  },
  methods: {
    ...mapActions(["updateLogin", "updateRegistro", "register"]),
    registro() {
      console.log("Realizar registro");
    },
    doLogin() {
      this.$emit("change");
      this.updateLogin(true);
      this.updateRegistro(false);
      //   this.$parent.dialog.value = !this.dialog.value;
    },
    submit() {
      this.dialog = false;
      let form = {
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation,
        name: this.name,
        phone: this.phone,
      };

      this.register(form);
    },
  },
};
</script>

<style></style>
