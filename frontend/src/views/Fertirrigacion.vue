<template>
  <div class="view">
    <v-alert
      class="onTop"
      v-if="error"
      dismissible
      border="left"
      color="red"
      type="error"
      transition="scale-transition"
      @input="error = ''"
      >{{ error }}</v-alert
    >
    <header-custom
      tour="fertirrigacion"
      name="Configuracion de Fertirrigación"
    ></header-custom>
    <v-container>
      <v-row>
        <v-col class="phControl">
          <v-container>
            <v-row>
              <v-col>
                <div class="ph">
                  <label for="ph">VALOR DE PH: </label>
                  <v-text-field
                    id="ph"
                    type="number"
                    :value="ph"
                    :min="0"
                    :max="14"
                    placeholder="pH"
                    @input="updatePH(parseInt($event))"
                  ></v-text-field>
                </div>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <div class="phPost">
                  <v-switch
                    inset
                    v-model="phPost"
                    :label="isActivePostRiego(phPost)"
                  ></v-switch>
                </div>
              </v-col>
              <v-col>
                <div class="phPre">
                  <v-switch
                    inset
                    v-model="phPre"
                    :label="isActivePreRiego(phPre)"
                  ></v-switch>
                </div>
              </v-col>
            </v-row>
            <v-row>
              <v-col>
                <div class="phRie">
                  <v-switch
                    inset
                    v-model="phRie"
                    :label="isActiveRiego(phRie)"
                  ></v-switch>
                </div>
              </v-col>
              <v-col>
                <div class="controlAbono">
                  <v-switch
                    inset
                    v-model="control"
                    :label="isSecuencial"
                  ></v-switch>
                </div>
              </v-col>
            </v-row>
          </v-container>
        </v-col>
      </v-row>

      <v-row class="lineaAbono">
        <v-col>
          <!-- <source-selector :options="abonos"></source-selector> -->
          <v-btn-toggle
            borderless
            tile
            group
            color="primary"
            class="lineaAbonoToggle"
            v-model="toggle_exclusive"
          >
            <v-btn
              v-for="index in numLineFertirrigation"
              :key="'lineBtn' + index"
            >
              | Linea {{ index }} de abonado |
            </v-btn>
          </v-btn-toggle>
        </v-col>
      </v-row>

      <v-row :key="'abono' + toggle_exclusive" class="selectorAbono">
        <v-container>
          <v-row justify="center">
            <v-col cols="auto" md="6" sm="12">
              <label for="seleccionAbono">Seleccione el abono deseado</label>
              <custom-select
                id="seleccionAbono"
                button
                @change="
                  lineFertirrigation[toggle_exclusive].fertilizer = $event
                "
                :selected="lineFertirrigation[toggle_exclusive].fertilizer"
                :values="sel"
              ></custom-select
            ></v-col>
            <v-col cols="auto" md="6" sm="12">
              <label for="seleccionConsigna"
                >Seleccione el formato deseado</label
              >
              <custom-select
                id="seleccionConsigna"
                button
                @change="updateType"
                :selected="lineFertirrigation[toggle_exclusive].controlType"
                :values="medicion"
              ></custom-select
            ></v-col>
          </v-row>
        </v-container>
      </v-row>
      <v-row :key="'Consignia' + toggle_exclusive" class="consigna">
        <v-container>
          <v-row justify="center">
            <v-col class="input" cols="auto" md="6" sm="12">
              <v-dialog
                transition="dialog-bottom-transition"
                v-if="typeConsigna"
                ref="dialog"
                v-model="modal"
                :return-value.sync="
                  lineFertirrigation[toggle_exclusive].consigna
                "
                persistent
                width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    class="centered-input"
                    hide-details
                    v-model="lineFertirrigation[toggle_exclusive].consigna"
                    label="Seleccione una hora"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-time-picker
                  @input="
                    lineFertirrigation[toggle_exclusive].consigna = $event
                  "
                  format="24hr"
                  use-seconds
                  v-if="modal"
                  v-model="lineFertirrigation[toggle_exclusive].consigna"
                  full-width
                >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="modal = false">
                    Cancelar
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="
                      $refs.dialog.save(
                        lineFertirrigation[toggle_exclusive].consigna
                      )
                    "
                  >
                    OK
                  </v-btn>
                </v-time-picker>
              </v-dialog>

              <v-text-field
                v-else
                type="number"
                min="0"
                placeholder="consigna"
                v-model="lineFertirrigation[toggle_exclusive].consigna"
              ></v-text-field>
            </v-col>

            <v-col class="input" cols="auto" md="6" sm="12">
              <v-dialog
                transition="dialog-bottom-transition"
                ref="dialog2"
                v-model="modal2"
                :return-value.sync="lineFertirrigation[toggle_exclusive].time"
                persistent
                width="290px"
              >
                <template v-slot:activator="{ on, attrs }">
                  <v-text-field
                    class="centered-input"
                    hide-details
                    v-model="lineFertirrigation[toggle_exclusive].time"
                    label="Seleccione la duración"
                    readonly
                    v-bind="attrs"
                    v-on="on"
                  ></v-text-field>
                </template>
                <v-time-picker
                  @input="lineFertirrigation[toggle_exclusive].time = $event"
                  format="24hr"
                  use-seconds
                  v-if="modal2"
                  v-model="lineFertirrigation[toggle_exclusive].time"
                  full-width
                >
                  <v-spacer></v-spacer>
                  <v-btn text color="primary" @click="modal2 = false">
                    Cancelar
                  </v-btn>
                  <v-btn
                    text
                    color="primary"
                    @click="
                      $refs.dialog2.save(
                        lineFertirrigation[toggle_exclusive].time
                      )
                    "
                  >
                    OK
                  </v-btn>
                </v-time-picker>
              </v-dialog>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <v-btn @click="createFertirrigation" class="mt-3">Guardar</v-btn>
            </v-col>
          </v-row>
        </v-container>
      </v-row>
    </v-container>
    <v-tour name="fertirrigacion" :steps="steps" :options="myOptions"></v-tour>
  </div>
</template>

<script>
import customSelect from "@/components/Select";
import headerCustom from "@/components/Header";
export default {
  components: {
    customSelect,
    headerCustom,
  },
  data() {
    return {
      phPre: false,
      phRie: false,
      phPost: false,
      control: false,
      ph: 0,
      selected: 0,
      sel: ["Abono 1", "Abono 2", "Abono 3", "Abono 4", "Abono 5", "Abono 6"],
      medicion: ["Tiempo", "Volumen", "Proporcional"],
      medicionSelected: 0,
      consigna: "",
      tiempoAbono: 0,
      abonos: [1, 2, 3, 4, 5, 6, 7],
      toggle_exclusive: 0,
      lineFertirrigation: [],
      numLineFertirrigation: 7,
      modal2: false,
      modal: false,
      time: "",
      error: "",
      myOptions: {
        useKeyboardNavigation: true,
        labels: {
          buttonSkip: "Saltar tour",
          buttonPrevious: "Anterior",
          buttonNext: "Siguiente",
          buttonStop: "Finalizar",
        },
      },
      steps: [
        {
          target: "#ph",
          header: {
            title: "Selector pH",
          },
          content:
            "Permite establecer el valor del pH",
        },
        {
          target: ".phPre",
          header: {
            title: "Selección prerriego",
          },
          content:
            "Selecciona si se quiere controlar el pH en la fase de prerriego",
        },
        {
          target: ".phRie",
          header: {
            title: "Selección riego",
          },
          content:
            "Selecciona si se quiere controlar el pH en la fase de riego",
        },
        {
          target: ".phPost",
          header: {
            title: "Selección postrriego",
          },
          content:
            "Selecciona si se quiere controlar el pH en la fase de postrriego",
        },
        {
          target: ".lineaAbono",
          header: {
            title: "Selección línea de abonado",
          },
          content:
            "Selecciona la línea de abonado a configurar",
        },
        
      ],
    };
  },
  created() {
    for (let index = 0; index < this.numLineFertirrigation; index++) {
      this.lineFertirrigation.push({
        fertilizer: 0,
        controlType: 0,
        consigna: "",
        time: "",
      });
    }
  },
  methods: {
    isActivePreRiego(bool) {
      return bool
        ? "EL CONTROL DE pH EN PRERIEGO ESTA ACTIVADO"
        : "EL CONTROL DE pH EN PRERIEGO ESTA DESACTIVADO";
    },
    isActiveRiego(bool) {
      return bool
        ? "EL CONTROL DE pH EN RIEGO ESTA ACTIVADO"
        : "EL CONTROL DE pH EN RIEGO ESTA DESACTIVADO";
    },
    isActivePostRiego(bool) {
      return bool
        ? "EL CONTROL DE pH EN POSTRIEGO ESTA ACTIVADO"
        : "EL CONTROL DE pH EN POSTRIEGO ESTA DESACTIVADO";
    },
    updatePH(value) {
      console.log(value);
      this.ph = value;
    },
    updateType(value) {
      this.lineFertirrigation[this.toggle_exclusive].controlType = value;
      this.lineFertirrigation[this.toggle_exclusive].consigna = "";
    },
    createFertirrigation() {
      if (
        this.lineFertirrigation.find(
          (element) => element.consigna == "" || element.time == ""
        )
      ) {
        this.error =
          "Debe configurar cada una de las lineas de abonado de manera individual";
      }
      let object = {
        ph: this.ph,
        phPreIrrigation: this.phPre,
        phIrrigation: this.phRie,
        phPostIrrigation: this.phPost,
        lineFertirrigation: this.lineFertirrigation,
      };
      console.log(object);
    },
  },
  computed: {
    isSecuencial() {
      return this.control
        ? "APLICAR ABONO DE MANERA SIMULTÁNEA"
        : "APLICAR ABONO DE MANERA SECUENCIAL";
    },
    typeConsigna() {
      return this.lineFertirrigation[this.toggle_exclusive].controlType == 0;
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.view {
  .onTop {
    position: fixed;
    z-index: 9950;
    top: 10px;
  }

  .input {
    width: 90%;
  }

  .phPre,
  .phRie,
  .phPost,
  .ph,
  .controlAbono {
    display: flex;
    align-items: center;
    margin: 0px 0px 0px 10%;
  }
  .ph {
    label {
      margin-right: 8px;
    }
    max-width: 180px;
    margin: 0px auto;
  }

  .lineaAbonoToggle {
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
  }

  .phControl,
  .lineaAbono,
  .selectorAbono,
  .consigna,
  .selectorConsignea,
  .tiempo {
    box-shadow: 5px 5px 15px $primaryDark, -5px -5px 15px #ffffff;
    border-radius: 5px;
    margin: 10px;
    padding: 10px 15px;
    background: $white;
  }

  //   .header {
  //     grid-area: header;
  //   }

  .phControl {
    display: flex;
    flex-wrap: wrap;
  }
}
</style>
