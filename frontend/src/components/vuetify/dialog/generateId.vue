<template>
  <v-dialog
    v-model="dialog"
    transition="dialog-bottom-transition"
    max-width="500"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-btn
        id="registroIdBtn"
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
          <form action="">
            <div
              v-for="item in listDeviceId.waittingId"
              :key="item.id"
              class="copy"
            >
              <span>
                {{ item.id }}
              </span>
              <div class="buttons">
                <v-btn v-clipboard="item.id" class="btn"
                  ><font-awesome-icon :icon="['far', 'copy']"
                /></v-btn>
                <v-btn class="btn" @click="deleteDeviceId(item.id)"
                  ><font-awesome-icon :icon="['fa', 'trash-alt']"
                /></v-btn>
              </div>
            </div>

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

  methods: {
    ...mapActions(["createDeviceId", "getDeviceId", "deleteDeviceId"]),
    generar() {
      this.createDeviceId();
    },
  },
  beforeMount() {
    this.getDeviceId();
  },
};
</script>

<style lang="scss" scoped>
h3 {
  word-wrap: break-word;
  text-overflow: none;
}
ul {
  display: table;
  margin: 0 auto;
}

form {
  padding: 0 !important;
}

.copy {
  width: 100%;
  box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px,
    rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
  padding: 10px;
  display: flex;
  justify-content: space-around;
  span {
    margin-right: 10px;
    word-wrap: break-word;
    width: 50%;
  }
}

.buttons {
  .btn {
    margin-right: 5px;
  }
  width: 50%;
  margin: auto 0px;
}
</style>
