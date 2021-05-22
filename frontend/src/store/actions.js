export default {
  // Función para actualizar los dias
  updateDays({ commit, state }, index) {
    // TODO:
    let obj = state.program.days;
    obj[index] = !obj[index];
    commit("updateDayProgram", obj);
  },

  updateLogin({ commit }, data) {
    commit("updateLogin", data);
  },
  updateRegistro({ commit }, data) {
    commit("updateRegistro", data);
  },
};
