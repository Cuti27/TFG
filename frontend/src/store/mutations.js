import Vue from "vue";

export default {
    // Mutación para cambiar los días del state
    updateDayProgram(state, array) {
        Vue.set(state.program, "days", array);
        //! No se esto porque hay que ponerlo
        state.program = {...state.program };
    },
    updateLogin(state, data) {
        state.showLogin = data;
    },
    updateRegistro(state, data) {
        state.showRegistro = data;
    },
    loadDigitalInput(state, array) {
        // Vue.set(state, "digitalInput", array);
        // state.digitalInput = {...state.digitalInput };
        state.digitalInput = array;
    },
    loadDigitalOutput(state, array) {
        // Vue.set(state, "digitalOutput", array);
        // state.digitalOutput = {...state.digitalOutput };
        state.digitalOutput = array;
    },
    loadAnalogicalInput(state, array) {
        // Vue.set(state, "analogicalInput", array);
        // state.analogicalInput = {...state.analogicalInput };

        state.analogicalInput = array;
    },
    loadAnalogicalOutput(state, array) {
        // Vue.set(state, "analogicalOutput", array);
        // state.analogicalOutput = {...state.analogicalOutput };

        state.analogicalOutput = array;
    },
    loadLogin(state, value) {
        state.auth = value.token;
        state.user = value.user;
    },
    loadLogout(state) {
        state.auth = "";
        state.user = {};
    },
};