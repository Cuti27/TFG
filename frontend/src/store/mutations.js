import Vue from "vue";
import mutationHead from "./Head/mutationsHead";
import mutationDevice from "./Device/mutationDevice";

export default {
  ...mutationHead,
  ...mutationDevice,
  // Mutación para cambiar los días del state
  updateDayProgram(state, array) {
    Vue.set(state.program, "days", array);
    //! No se esto porque hay que ponerlo
    state.program = { ...state.program };
  },
  updateLogin(state, data) {
    state.showLogin = data;
  },
  updateRegistro(state, data) {
    state.showRegistro = data;
  },
  loadLogin(state, value) {
    state.auth = value.token;
    state.user = value.user;
    localStorage.setItem("sessionTokenGenhidro", JSON.stringify(value.token));
  },
  loadLogout(state) {
    state.auth = "";
    state.user = {};
    localStorage.removeItem("sessionTokenGenhidro");
  },
};
