<template>
  <v-dialog
    v-model="dialog"
    transition="dialog-bottom-transition"
    max-width="500"
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
        ><div v-if="show">
          Generar id <font-awesome-icon icon="plus-square" />
        </div>
        <font-awesome-icon v-else icon="plus-square" />
      </v-btn>
    </template>
    <template v-slot:default="dialog">
      <v-card>
        <v-toolbar color="primary" dark
          ><h2>Identificadores en espera</h2></v-toolbar
        >
        <v-container class="pa-4">
          <form action="" class="login-form px-10">
            <span v-for="item in listDeviceId.waittingId" :key="item.id">
              {{ item.id }}
              <v-btn v-if="canCopy"
                ><font-awesome-icon
                  @click="copy(item.id)"
                  :icon="['far', 'copy']"
              /></v-btn>
            </span>
            <v-spacer></v-spacer>
            <v-btn class="mt-5" @click="generar()" id="registro"
              >Generar id</v-btn
            >
          </form>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog.value = false">
            Cerrar
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
      show1: false,
      canCopy: false,
    };
  },
  props: {
    show: {
      type: Boolean,
      requred: false,
    },
  },
  computed: {
    ...mapGetters(["listDeviceId"]),
  },
  created() {
    this.canCopy = !!navigator.clipboard;
  },

  methods: {
    ...mapActions(["createDeviceId", "getDeviceId"]),
    generar() {
      this.createDeviceId();
    },
    async copy(s) {
      navigator.clipboard.writeText(s);
    },
  },
  beforeMount() {
    this.getDeviceId();
  },
};
</script>

<style>
h3 {
  word-wrap: break-word;
  text-overflow: none;
}
ul {
  display: table;
  margin: 0 auto;
}
</style>
