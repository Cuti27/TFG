import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import { BootstrapVue, IconsPlugin } from "bootstrap-vue";
import VueTour from "vue-tour";
import vuetify from "@/plugins/vuetify"; // path to vuetify export

import fontAwesome from "@/plugins/fontAwesome";
Vue.component("font-awesome-icon", fontAwesome);

require("vue-tour/dist/vue-tour.css");

Vue.use(BootstrapVue);
Vue.use(IconsPlugin);
Vue.config.productionTip = false;

Vue.use(VueTour);

document.title = "Genhidro";

new Vue({
  router,
  store,
  vuetify,
  data: {
    cabezales: [
      {
        name: "Cabezal 1",
        id: 123,
        info: new Date(2020, 3, 1),
      },
      {
        name: "Cabezal 2",
        id: 234,
        info: new Date(2021, 1, 25),
      },
      {
        name: "Cabezal 3",
        id: 345,
        info: new Date(2021, 3, 12),
      },
      {
        name: "Cabezal 4",
        id: 456,
        info: new Date(2020, 7, 1, 10, 10),
      },
    ],
    programas: [
      {
        id: 123,
        name: "Programa riego basico",
        info: [true, false, true, false, true, false, false],
        sectores: ["1", "2", "3"],
        horaInicio: new Date(),
      },
      {
        id: 234,
        name: "Programa riego num 1",
        info: [true, false, true, false, true, false, false],
        sectores: ["1", "2", "3"],
        horaInicio: new Date(),
      },
      {
        id: 345,
        name: "Programa riego avanzado",
        info: [true, true, true, true, true, false, false],
        sectores: ["1", "2", "3"],
        horaInicio: new Date(),
      },
      {
        id: 456,
        name: "Programa riego SP32",
        info: [false, false, false, false, false, true, true],
        sectores: ["1", "2", "3"],
        horaInicio: new Date(),
      },
      {
        id: 567,
        name: "Programa riego Logo",
        info: [true, false, false, false, true, true, true],
        sectores: ["1", "2", "3"],
        horaInicio: new Date(),
      },
    ],
  },
  render: (h) => h(App),
}).$mount("#app");
