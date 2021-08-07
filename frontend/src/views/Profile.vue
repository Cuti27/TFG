<template>
  <div class="profileHistory">
    <div class="header">
       <v-card >
          <v-img width="100%" max-height="120" position="bottom -50px center" :src="require('../assets/header.jpg')"></v-img>
          <v-col id="top15">
            <v-avatar size="100" style="position:relative; top: -50px;">
              <v-img class="myAvatar" src="https://cdn.vuetifyjs.com/images/profiles/marcus.jpg"></v-img>
            </v-avatar>
          </v-col>
            <v-list-item color="rgba(0, 0, 0, .4)">
              <v-list-item-content>
                <v-list-item-title class="title">Marcus Obrien</v-list-item-title>
                <v-list-item-subtitle>Network Engineer</v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
      </v-card>
    </div>
    <v-container class="body">
      <v-row>
        <v-col>
          <div class="devices">
            <!-- Listado de dispositivos -->
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <div class="infoProfile">
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
                    <template v-slot:label="item"> {{ item.value }}h </template>
                  </v-sparkline>
                </v-sheet>
              </v-card-text>

              <v-card-text>
                <div class="text-h4 font-weight-thin">
                  Horas de riego semanales
                </div>
              </v-card-text>
              <v-card-actions class="justify-center">
                <v-select
            :items="items"
            label="Todos los cabezales"
            outlined
            clearable
            v-model="selectedItem"
                 ></v-select>
                </v-card-actions>
            </v-card>
          </div>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <div class="week">
            <v-sheet height="400">
              <v-calendar
                ref="calendar"
                :now="today"
                :value="today"
                :events="events"
                color="primary"
                type="week"
              ></v-calendar>
            </v-sheet>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
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
      today: "2019-01-08",
      selectedGradient: ["#41B883", "#ffffff"],
      padding: 8,
      radius: 10,
      width: 1.8,
      value: [0, 2, 5, 9, 0, 10, 7],
      items: ["Cabezal 1", "Cabezal 2", "Cabezal 3"],
      selectedItem: null,
    };
  },
};
</script>

<style lang="scss" scoped>

#top15{
    max-height: 50px;
}

.myAvatar{
    border: 1px solid black !important;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
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