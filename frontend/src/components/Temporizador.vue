<template>
  <div class="temporizador">
    <h3
      :style="{
        'align-self': title && windowWidth >= 990 ? 'end' : 'center',
        'mt-2': true,
      }"
    >
      <slot></slot>
    </h3>
    <hr />
    <div class="inicio mt-5">
      <h3 v-if="title || windowWidth < 1030">Hora de inicio</h3>
      <div class="mx-2 input-time">
        <v-dialog
          transition="dialog-bottom-transition"
          ref="dialog"
          v-model="modal"
          :return-value.sync="time"
          persistent
          width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <div :class="{ 'centered-input': true, 'mt-2': true }">
              <v-text-field
                hide-details
                @input="update"
                v-model="time"
                label="Seleccione una hora"
                type="time"
                step="1"
              ></v-text-field>
              <font-awesome-icon
                icon="clock"
                size="lg"
                v-bind="attrs"
                v-on="on"
              />
            </div>
          </template>
          <v-time-picker
            class="clockIcon"
            @input="update"
            format="24hr"
            use-seconds
            v-if="modal"
            v-model="time"
            full-width
          >
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="modal = false"> Cancel </v-btn>
            <v-btn text color="primary" @click="$refs.dialog.save(time)">
              OK
            </v-btn>
          </v-time-picker>
        </v-dialog>
      </div>
    </div>
    <div class="duracion">
      <h3 v-if="title || windowWidth < 1030">Duración</h3>
      <div class="mx-2 mb-2 input-time">
        <v-dialog
          transition="dialog-bottom-transition"
          ref="dialog1"
          v-model="modal1"
          :return-value.sync="time1"
          persistent
          width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <div :class="{ 'centered-input': true, 'mt-2': true }">
              <v-text-field
                hide-details
                @input="update"
                v-model="time1"
                label="Seleccione una hora"
                type="time"
                step="1"
              ></v-text-field>
              <font-awesome-icon
                icon="clock"
                size="lg"
                v-bind="attrs"
                v-on="on"
              />
            </div>
          </template>
          <v-time-picker
            class="clockIcon"
            @input="update"
            format="24hr"
            use-seconds
            v-if="modal1"
            v-model="time1"
            full-width
          >
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="modal1 = false"> Cancel </v-btn>
            <v-btn text color="primary" @click="$refs.dialog1.save(time1)">
              OK
            </v-btn>
          </v-time-picker>
        </v-dialog>
      </div>
    </div>
    <div class="postriego">
      <h3 v-if="title || windowWidth < 1030">Tiempo de postriego</h3>
      <div class="mx-2 mb-2 input-time">
        <v-dialog
          transition="dialog-bottom-transition"
          ref="dialog2"
          v-model="modal2"
          :return-value.sync="time2"
          persistent
          width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <div :class="{ 'centered-input': true, 'mt-2': true }">
              <v-text-field
                hide-details
                @input="update"
                v-model="time2"
                label="Seleccione una hora"
                type="time"
                step="1"
              ></v-text-field>
              <font-awesome-icon
                icon="clock"
                size="lg"
                v-bind="attrs"
                v-on="on"
              />
            </div>
          </template>
          <v-time-picker
            class="clockIcon"
            @input="update"
            format="24hr"
            use-seconds
            v-if="modal2"
            v-model="time2"
            full-width
          >
            <v-spacer></v-spacer>
            <v-btn text color="primary" @click="modal2 = false"> Cancel </v-btn>
            <v-btn text color="primary" @click="$refs.dialog2.save(time2)">
              OK
            </v-btn>
          </v-time-picker>
        </v-dialog>
      </div>
    </div>
    <font-awesome-icon
      :style="{ 'align-self': title && windowWidth >= 1030 ? 'end' : 'center' }"
      @click="$emit('delete', id)"
      icon="trash-alt"
      size="2x"
    />
  </div>
</template>

<script>
export default {
  props: {
    title: Boolean,
    id: Number,
    value: Object,
    disabled: Boolean,
  },
  data() {
    return {
      time: "",
      modal: false,
      time1: "",
      modal1: false,
      time2: "",
      modal2: false,
      inicioHora: this.value.inicio[0],
      inicioMinutos: this.value.inicio[1],
      inicioSegundos: this.value.inicio[2],
      duracionHora: this.value.duracion[0],
      duracionMinutos: this.value.duracion[1],
      duracionSegundos: this.value.duracion[2],
      postHora: this.value.post[0],
      postMinutos: this.value.post[1],
      postSegundos: this.value.post[2],
      windowWidth: 0,
      windowHeight: 0,
    };
  },
  computed: {
    temporizador() {
      return {
        inicio: this.time,
        duracion: this.time1,
        post: this.time2,
      };
    },
  },
  methods: {
    update() {
      this.$emit("input", this.temporizador);
    },
    getWindowWidth() {
      this.windowWidth = document.documentElement.clientWidth;
    },

    getWindowHeight() {
      this.windowHeight = document.documentElement.clientHeight;
    },
  },
  mounted() {
    this.$nextTick(function () {
      window.addEventListener("resize", this.getWindowWidth);
      window.addEventListener("resize", this.getWindowHeight);

      //Init
      this.getWindowWidth();
      this.getWindowHeight();
    });

    if (this.inicioHora && this.inicioMinutos && this.inicioSegundos)
      this.time = `${this.inicioHora}:${this.inicioMinutos}:${this.inicioSegundos}`;
    if (this.duracionHora && this.duracionMinutos && this.duracionSegundos)
      this.time1 = `${this.duracionHora}:${this.duracionMinutos}:${this.duracionSegundos}`;
    if (this.postHora && this.postMinutos && this.postSegundos)
      this.time2 = `${this.postHora}:${this.postMinutos}:${this.postSegundos}`;
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.getWindowWidth);
    window.removeEventListener("resize", this.getWindowHeight);
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

hr {
  border: 0;
  height: 1px;
  background-image: linear-gradient(
    to right,
    rgba(0, 0, 0, 0),
    rgba(0, 0, 0, 0.75),
    rgba(0, 0, 0, 0)
  );
}

.input-time {
  width: 100%;
}

.temporizador label {
  left: 30px !important;
  right: auto;
  position: absolute;
}

.centered-input {
  width: 100%;
  margin: 0 20px;
  margin-left: 30px;
  input {
    text-align: center;
  }
}

.temporizador {
  transition: all 0.5s ease;
  margin: 10px 50px;
  flex-wrap: wrap;
  min-width: 220px;
  border: 1px solid $primaryDark;
  border-radius: 15px;
  padding: 5px;
  box-shadow: rgba(22, 62, 93, 0.5) 0px 1px 2px 0px,
    rgba(60, 64, 67, 0.3) 0px 2px 6px 2px;

  .inicio,
  .duracion,
  .postriego {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    // max-width: 185px;
    width: 100%;

    div {
      display: flex;
    }
  }

  svg {
    margin: 10px;
    margin-top: 20px;
    color: $primaryDark;
    cursor: pointer;

    &:hover {
      color: $primary;
    }
  }

  &:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 25px 0 rgba(34, 41, 47, 0.25);
  }
}

@media (max-width: 1030px) {
  .temporizador {
    justify-content: center;
    margin: 10px 15px;
    flex-direction: column;
    width: 30%;
  }
}

@media (max-width: 576px) {
  .temporizador {
    margin: 10px 10px;
  }
}
</style>
