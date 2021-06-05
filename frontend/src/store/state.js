import stateHead from "./Head/stateHead";
import stateDevice from "./Device/stateDevice";

export default {
    ...stateHead,
    ...stateDevice,
    user: {},
    auth: JSON.parse(localStorage.getItem("sessionTokenGenhidro")),
    showRegistro: false,
    showLogin: false,
    program: {
        days: [false, false, false, false, false, false, false],
    },
    numProgramas: 5,
    programas: [],
    programName: "",
    comunicationError: "",
};