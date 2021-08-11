<template>
  <div class="profileHistory">
    <div class="header">
      <v-card>
        <v-img
          width="100%"
          max-height="120"
          min-height="120"
          position="bottom -90px center"
          :src="require('../assets/header.jpg')"
        ></v-img>
        <v-col id="top15">
          <v-avatar size="100" style="position: relative; top: -50px">
            <v-img class="myAvatar" :src="user.img"></v-img>
          </v-avatar>
        </v-col>
        <v-list-item color="rgba(0, 0, 0, .4)">
          <v-list-item-content>
            <v-list-item-title class="title">{{ user.name }}</v-list-item-title>
            <v-list-item-subtitle
              >{{ user.email }} - {{ user.phone }}</v-list-item-subtitle
            >
          </v-list-item-content>
        </v-list-item>
      </v-card>
    </div>
    <v-container class="body">
      <v-row>
        <v-col class="py-5 px-0">
          <div class="devices">
            <h3 class="mt-2">Información del usuario</h3>
            <h5 class="mt-2">
              Puede seleccionar un cabezal para filtrar la información
            </h5>
            <v-select
              :items="cabezales"
              label="Todos los cabezales"
              outlined
              clearable
              v-model="selectedCabezal2"
            >
              <template slot="selection" slot-scope="data">
                {{ data.item.name }}
              </template>
              <template slot="item" slot-scope="data">
                {{ data.item.name }}
              </template>
            </v-select>
            <h5 v-if="selectedCabezal2" class="mt-2">
              Puedes fitlrar por un programa en especifico
            </h5>
            <v-select
              v-if="selectedCabezal2"
              :items="programas"
              label="Todos los cabezales"
              outlined
              clearable
              v-model="selectedProgram"
            >
              <template slot="selection" slot-scope="data">
                {{ data.item.name }}
              </template>
              <template slot="item" slot-scope="data">
                {{ data.item.name }}
              </template>
            </v-select>
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col class="pt-3 px-0">
          <v-container class="infoProfile">
            <v-row>
              <v-col>
                <v-card
                  class="mx-auto text-center"
                  color="primary"
                  dark
                  max-width="600"
                >
                  <v-card-text>
                    <v-sheet color="rgba(0, 0, 0, .12)">
                      <v-sparkline
                        :gradient="selectedGradient"
                        :line-width="width"
                        :padding="padding"
                        :smooth="radius || false"
                        :value="value"
                        color="rgba(255, 255, 255, .7)"
                        auto-draw
                        stroke-linecap="round"
                      >
                        <template class="text-h5" v-slot:label="item">
                          {{ item.value }}h
                        </template>
                      </v-sparkline>
                    </v-sheet>
                  </v-card-text>

                  <v-card-text>
                    <div class="text-h4 font-weight-thin">
                      Horas de riego semanales
                    </div>
                  </v-card-text>
                </v-card>
              </v-col>
              <v-col>
                <v-card
                  class="mx-auto text-center font-weight-thin"
                  color="secondary"
                  dark
                  max-width="600"
                >
                  <v-card-text>
                    <v-sheet color="rgba(0, 0, 0, .12)">
                      <v-sparkline
                        :gradient="selectedGradient"
                        :line-width="width"
                        :padding="padding"
                        :smooth="radius || false"
                        :value="valueHumidity"
                        color="rgba(255, 255, 255, .7)"
                        auto-draw
                        stroke-linecap="round"
                      >
                        <template class="text-h5" v-slot:label="item">
                          {{ item.value }}%
                        </template>
                      </v-sparkline>
                    </v-sheet>
                  </v-card-text>

                  <v-card-text>
                    <div class="text-h4 font-weight-thin">
                      Humedad durante el día
                    </div>
                  </v-card-text>
                </v-card>
              </v-col>
            </v-row>
          </v-container>
        </v-col>
      </v-row>
      <v-row>
        <v-col class="py-5 px-0">
          <div class="week">
            <v-sheet tile height="54" class="d-flex">
              <v-btn icon v-if="windowWidth < 720" class="ma-2" @click="prev">
                <font-awesome-icon icon="arrow-circle-left" size="2x" />
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn icon v-if="windowWidth < 720" class="ma-2" @click="next">
                <font-awesome-icon icon="arrow-circle-right" size="2x" />
              </v-btn>
            </v-sheet>
            <v-sheet height="600">
              <v-calendar
                ref="calendar"
                :now="varToday"
                :value="varToday"
                :events="events"
                color="primary"
                :type="type"
                :event-overlap-threshold="30"
                :weekdays="[1, 2, 3, 4, 5, 6, 0]"
              ></v-calendar>
            </v-sheet>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  data() {
    return {
      user: {
        name: "Antonio Martinez Cremades",
        email: "antonio@correo.com",
        phone: "679974557",
        img: "https://avatars0.githubusercontent.com/u/9064066?v=4&s=460",
      },
      events: [
        {
          name: "Weekly Meeting",
          start: "2019-01-07 09:00",
          end: "2019-01-07 10:00",
        },
        {
          name: `Thomas' Birthday`,
          start: "2019-01-10",
        },
        {
          name: "Mash Potatoes",
          start: "2019-01-09 12:30",
          end: "2019-01-09 15:30",
        },
      ],
      varToday: this.today,
      selectedGradient: ["#41B883", "#ffffff"],
      padding: 8,
      radius: 10,
      width: 1.8,
      value: [0, 2, 5, 9, 0, 10, 7],
      valueHumidity: [54, 56, 87, 89, 56, 12, 43, 54, 87, 23, 63],
      selectedCabezal: null,
      selectedCabezal2: null,
      selectedProgram: null,
      calendarType: "week",
    };
  },
  methods: {
    ...mapActions(["getCabezales", "listProgram"]),
    prev() {
      if(new Date(this.varToday).getDay() != 1) {
        this.varToday = new Date(this.varToday);
        this.varToday.setDate(this.varToday.getDate() - 1);
        this.varToday = this.fromDateToString(this.varToday);
      }
    },
    next() {
      if(this.type == "4day"){
        if (new Date(this.varToday).getDay() != 4) {
        this.varToday = new Date(this.varToday);
        this.varToday.setDate(this.varToday.getDate() + 1);
        this.varToday = this.fromDateToString(this.varToday);
      }
      }
      else if (new Date(this.varToday).getDay() != 0) {
        this.varToday = new Date(this.varToday);
        this.varToday.setDate(this.varToday.getDate() + 1);
        this.varToday = this.fromDateToString(this.varToday);
      }
    },
    fromDateToString(date) {
      let dd = String(date.getDate()).padStart(2, "0");
      let mm = String(date.getMonth() + 1).padStart(2, "0");
      let yyyy = date.getFullYear();
      return `${yyyy}-${mm}-${dd}`;
    },
  },
  beforeMount() {
    this.getCabezales();
    this.varToday = this.today;
  },
  computed: {
    ...mapGetters(["cabezales", "programas", "windowWidth"]),
    type() {
      return this.windowWidth > 720
        ? this.calendarType
        : this.windowWidth > 480
        ? "4day"
        : "day";
    },
    today() {
      var today = new Date();
      return this.fromDateToString(today);
    },
  },
  watch: {
    selectedCabezal2(val, old) {
      if (val && val != old) {
        this.listProgram();
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";

.container {
  min-width: 100%;
}

.devices,
.infoProfile,
.week {
  box-shadow: 5px 5px 15px $primaryDark, -5px -5px 15px #ffffff;
  border-radius: 5px;
  padding: 10px 15px;
  width: 100%;
  background: $white;
}
#top15 {
  max-height: 50px;
}

.myAvatar {
  border: 1px solid black !important;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px,
    rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
}

.my-event {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  border-radius: 2px;
  background-color: #1867c0;
  color: #ffffff;
  border: 1px solid #1867c0;
  font-size: 12px;
  padding: 3px;
  cursor: pointer;
  margin-bottom: 1px;
  left: 4px;
  margin-right: 8px;
  position: relative;
}

.my-event.with-time {
  position: absolute;
  right: 4px;
  margin-right: 0px;
}
</style>