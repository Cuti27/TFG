import stateHead from "./Head/stateHead";
import stateDevice from "./Device/stateDevice";

export default {
  ...stateHead,
  ...stateDevice,
  user: {},
  userHistory: [],
  auth: JSON.parse(localStorage.getItem("sessionTokenGenhidro")),
  showRegistro: false,
  showLogin: false,
  program: {
    days: [false, false, false, false, false, false, false],
  },
  numProgramas: 0,
  programas: [],
  programName: "",
  comunicationError: "",
  comunicationSuccess: "",
  isLoading: 0,
  updateName: false,
  windowWidth: 1980,
  windowHeight: 1080,
  tempProgram: {},
};
