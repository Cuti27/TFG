import Vue from "vue";

export default {
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
};
