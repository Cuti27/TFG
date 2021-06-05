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
        state.program = {...state.program };
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

    loadListProgram(state, value) {
        value.listPrograms.data.forEach((element, index) => {
            element.timer = value.timer[index];
            element.programDay = [element.mon, element.tue, element.wed, element.thu, element.fri, element.sat, element.sun];
            delete element.mon;
            delete element.tue;
            delete element.wed;
            delete element.thu;
            delete element.fri;
            delete element.sat;
            delete element.sun;
            element.sector = value.sector[index];
        })
        state.programas = value.listPrograms.data;
        state.numProgramas = value.count;
    },

    updateProgramName(state, value) {
        state.programName = value;
    },
    closeErrorMutation(state) {
        state.comunicationError = false;
    },
    addGlobalError(state, value) {
        state.comunicationError = value;
    }
};