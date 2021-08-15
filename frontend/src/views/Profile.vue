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
          <v-avatar
            color="primary"
            :size="user.img ? 100 : 70"
            style="position: relative; top: -50px"
          >
            <v-img v-if="user.img" class="myAvatar" :src="user.img"></v-img>
            <span v-else>{{ userInitial }}</span>
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
          <div class="history">
            <h3 class="pt-5">Historial del usuario</h3>
            <perfect-scrollbar
              class="scroll-area"
              :settings="perfectScrollbarSettings"
            >
              <v-timeline align-top :dense="$vuetify.breakpoint.smAndDown">
                <v-timeline-item
                  v-for="(item, i) in userHistory"
                  :key="i"
                  fill-dot
                >
                  <v-card :color="i % 2 == 0 ? 'primary' : 'secondary'" dark>
                    <v-card-title class="text-h6">
                      {{ formatDate(item.created_at) }}
                    </v-card-title>
                    <v-card-text class="white text--primary">
                      <p>
                        {{ item.description }}
                      </p>
                    </v-card-text>
                  </v-card>
                </v-timeline-item>
              </v-timeline>
            </perfect-scrollbar>
          </div>
        </v-col>
      </v-row>
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
              class="select-center"
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

              <template slot="append-outer">
                <v-btn @click="fetchAllProgram">Todos los programas</v-btn>
              </template>
            </v-select>
            <h5 v-if="selectedCabezal2" class="mt-2">
              Puedes fitlrar por un programa en especifico
            </h5>
            <v-select
              v-if="selectedCabezal2"
              :items="programProfile"
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
                        :value="irrigationHours"
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
                @click:event="showEvent($event)"
                ref="calendar"
                :now="varToday"
                :value="varToday"
                :events="programEvents"
                color="primary"
                :type="type"
                :event-overlap-threshold="30"
                :weekdays="[1, 2, 3, 4, 5, 6, 0]"
              ></v-calendar>
            </v-sheet>
          </div>
        </v-col>
      </v-row>
      <v-dialog
      v-model="dialog"
      max-width="360"
    >
      <v-card>
        <v-card-title class="headline">Información del programa:</v-card-title>

        <v-card-text>
          <h3>{{selectedEvent.name}}</h3>
          <v-container>
            <v-row>
              <v-col>
                <span><strong>Activo:</strong> {{selectedEvent.active ? "Si" : "No"}}</span><br>
                <span><strong>Identificador:</strong> {{ selectedEvent.id }}</span>
              </v-col>
          </v-row>
          <v-row>
            <v-col>
              <div v-for="timer in selectedEvent.timer" :key="timer.id">
                <span><strong>Hora de inicio:</strong> {{timer.timeStart}}</span><br>
                <span><strong>Duración:</strong> {{ timer.duration}}</span><br>
                <span><strong>Fertirrigación:</strong> {{timer.postIrrigation}}</span>
              </div>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <day-selector disable xs :dias="selectedEvent.programDay"></day-selector>
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <span><strong>Sectores:</strong></span><br>
              <div v-for="sector in selectedEvent.sector" :key="sector.id">
                <span>({{sector.id}}) {{sector.name}}</span><br>
              </div>
            </v-col>
          </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="dialog = false"
          >
            Cerrar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    </v-container>
  </div>
</template>

<script>
import { PerfectScrollbar } from "vue2-perfect-scrollbar";
import daySelector from "@/components/DaySelector";
import { mapActions, mapGetters, mapState } from "vuex";
import "vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css";
export default {
  components: {
    PerfectScrollbar,
    daySelector
  },
  data() {
    return {
      perfectScrollbarSettings: {
        maxScrollbarLength: 60,
        wheelPropagation: false,
      },
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
      dialog: false,
      selectedEvent: {}
    };
  },
  methods: {
    ...mapActions([
      "getCabezales",
      "listProgram",
      "fetchUserHistory",
      "setSelectedHead",
      "fetchProgramByHead",
      "fetchAllProgram"
    ]),
    showEvent(event) {
      this.selectedEvent = event.event.program;
      this.dialog = true;
    },
    prev() {
      if (new Date(this.varToday).getDay() != 1) {
        this.varToday = new Date(this.varToday);
        this.varToday.setDate(this.varToday.getDate() - 1);
        this.varToday = this.fromDateToString(this.varToday);
      }
    },

    next() {
      if (this.type == "4day") {
        if (new Date(this.varToday).getDay() != 4) {
          this.varToday = new Date(this.varToday);
          this.varToday.setDate(this.varToday.getDate() + 1);
          this.varToday = this.fromDateToString(this.varToday);
        }
      } else if (new Date(this.varToday).getDay() != 0) {
        this.varToday = new Date(this.varToday);
        this.varToday.setDate(this.varToday.getDate() + 1);
        this.varToday = this.fromDateToString(this.varToday);
      }
    },
    toWeekDay(val) {
      return this.week.find((day) => {
        const correctDay = new Date(day);
        return correctDay.getDay() == val;
      });
    },
    fromDateToString(date) {
      let dd = String(date.getDate()).padStart(2, "0");
      let mm = String(date.getMonth() + 1).padStart(2, "0");
      let yyyy = date.getFullYear();
      return `${yyyy}-${mm}-${dd}`;
    },
    formatDate(d) {
      let date = new Date(d);
      var dateString =
        date.getFullYear() +
        "-" +
        ("0" + (date.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + date.getDate()).slice(-2) +
        " " +
        ("0" + date.getHours()).slice(-2) +
        ":" +
        ("0" + date.getMinutes()).slice(-2) +
        ":" +
        ("0" + date.getSeconds()).slice(-2);
      return dateString;
    },
    addHour(date, string) {
      let time = string.split(":");
      date.setTime(
        date.getTime() +
          time[0] * 60 * 60 * 1000 +
          time[1] * 60 * 1000 +
          time[2] * 1000
      );
      return new Date(date);
    },
  },
  beforeMount() {
    this.getCabezales();
    this.varToday = this.today;
    this.fetchUserHistory();
  },
  computed: {
    ...mapState(["user", "userHistory", "programProfile"]),
    ...mapGetters(["cabezales", "windowWidth"]),
    irrigationHours() {
      let hours = [0, 0, 0, 0, 0, 0, 0];
      this.programProfile.forEach((programa) => {
        programa.programDay.forEach((day, index) => {
          if (day) {
            programa.timer.forEach((time) => {
              let duration = time.duration.split(":");
              duration = parseFloat(duration[0]) + parseFloat(duration[1]/60) + parseFloat(duration[2]/60/60);
              hours[(index + 1) % 7] += duration;
            });
          }
        });
      });
      return hours;
    },
    userInitial() {
      if (!this.user || !this.user.name) return "";
      let rgx = new RegExp(/(\p{L}{1})\p{L}+/, "gu");

      let initials = [...this.user.name.matchAll(rgx)] || [];

      initials = (
        (initials.shift()?.[1] || "") + (initials.pop()?.[1] || "")
      ).toUpperCase();

      return initials;
    },
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
    week() {
      let curr = new Date();
      let week = [];

      if(curr.getDay() == 0){
        let yesterday = new Date(curr.getTime());
        yesterday.setDate(curr.getDate() - 1);  
        curr = yesterday  
      }

      for (let i = 1; i <= 7; i++) {
        let first = curr.getDate() - curr.getDay() + i;
        let day = new Date(curr.setDate(first)).toISOString().slice(0, 10);
        week.push(day);
      }
      return week;
    },
    programEvents() {
      let events = [];
      this.programProfile.forEach((programa) => {
        let days = [];
        programa.programDay.forEach((day, index) => {
          if (day) {
            days.push(this.toWeekDay((index + 1) % 7));
          }
        });
        days.forEach((day) => {
          programa.timer.forEach((time) => {
            const start = `${day} ${time.timeStart}`;
            let eventDay = new Date(start);
            const end = this.addHour(eventDay, time.duration);
            events.push({
              name: programa.name,
              start,
              end: this.formatDate(end),
              color: programa.active ? "primary" : "grey darken-1",
              program: programa
            });
            let endDay = new Date(end);
            const fertirrigation = this.addHour(endDay, time.postIrrigation);
            events.push({
              name: "Fertirrigacion",
              start: this.formatDate(end),
              end: this.formatDate(fertirrigation),
              color: programa.active ? "secondary" : "grey darken-2",
              program: programa
            });
          });
        });
      });
      return events;
    },
  },
  watch: {
    selectedCabezal2(val, old) {
      if (val && val != old) {
        this.setSelectedHead(val);
        this.fetchProgramByHead(val.id);
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@/css/colorSchema.scss";


.select-center{
  &:first-child{
        margin-top: 10px !important;
    }
}

.scroll-area {
  max-width: 100%;
  max-height: 725px;
  overflow: hidden;
  padding: 10px 15px;
}

.container {
  min-width: 100%;
}

.devices,
.infoProfile,
.week,
.history {
  box-shadow: 5px 5px 15px $primaryDark, -5px -5px 15px #ffffff;
  border-radius: 5px;
  padding: 10px 15px;
  width: 100%;
  background: $white;
}
#top15 {
  max-height: 40px;
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