import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";

Vue.use(Vuetify);

const opts = {
    icons: {
        iconfont: "faSvg", // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'faSvg'
    },
    theme: {
        themes: {
            light: {
                primary: "#6890c3",
                secondary: "#456185",
                accent: "#bbca56",
                error: "#b71c1c",
            },
        },
    },
};

export default new Vuetify(opts);