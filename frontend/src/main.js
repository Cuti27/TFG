import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import VueClipboard from "vue-clipboard2";
import VueTour from "vue-tour";
import vuetify from "@/plugins/vuetify"; // path to vuetify export

import fontAwesome from "@/plugins/fontAwesome";
import Clipboard from 'v-clipboard'

Vue.use(Clipboard)
Vue.component("font-awesome-icon", fontAwesome);

require("vue-tour/dist/vue-tour.css");
VueClipboard.config.autoSetContainer = true;
Vue.use(VueClipboard);

Vue.config.productionTip = false;

Vue.use(VueTour);

document.title = "Genhidro";

new Vue({
  router,
  store,
  vuetify,
  data: {},
  render: (h) => h(App),
}).$mount("#app");
