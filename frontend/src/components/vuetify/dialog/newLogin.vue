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
        ><div v-if="show">Login <font-awesome-icon icon="sign-in-alt" /></div>
        <font-awesome-icon v-else icon="sign-in-alt" />
      </v-btn>
    </template>
    <template v-slot:default="dialog">
      <v-card>
        <v-toolbar color="primary" dark><h2>Inicar sesion</h2></v-toolbar>
        <v-container class="pa-2">
          <form action="" class="login-form px-2">
            <v-text-field
              class="mt-2"
              label="Correo"
              :rules="rulesUser"
              hide-details="auto"
              v-model="email"
              type="email"
            ></v-text-field>
            <v-text-field
              class="mt-2"
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
            <v-btn class="mt-2" id="recuperar"
              >¿Has olvidado la contraseña?</v-btn
            >
            <v-spacer></v-spacer>
            <v-btn class="mt-2" @click="doRegistro()" id="registro"
              >Registrate</v-btn
            >
          </form>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog.value = false">
            Cancelar
          </v-btn>

          <v-btn color="blue darken-1" text @click="submit()">
            Inicar sesion
          </v-btn>
        </v-card-actions>
      </v-card>
    </template>
  </v-dialog>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data: () => {
    return {
      dialog: false,
      rulesUser: [
        (value) => !!value || "Obligatorio",
        (value) => (value && value.length >= 3) || "Min 3 caracteres",
      ],
      rules: {
        required: (value) => !!value || "Obligatorio.",
      },
      show1: false,
      password: "",
      email: "",
    };
  },
  props: {
    show: {
      type: Boolean,
      requred: false,
    },
  },
  computed: {
    ...mapGetters(["showRegistro", "showLogin"]),
  },

  methods: {
    ...mapActions(["updateLogin", "updateRegistro", "login"]),
    submit() {
      this.dialog = false;
      let form = {
        email: this.email,
        password: this.password,
      };

      this.login(form);
    },
    doRegistro() {
      this.dialog = false;
      this.updateLogin(false);
      this.updateRegistro(true);
    },
  },
  watch: {
    dialog: function (newVal, oldVal) {
      if (newVal != oldVal) this.updateLogin(newVal);
    },
    showRegistro: function (newVal) {
      if (newVal) {
        this.dialog = false;
        this.updateLogin(false);
      }
    },
    showLogin: function (newVal) {
      this.dialog = newVal;
    },
  },
};
</script>

<style></style>
