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
  programas: [
    {
      id: 1234,
      nombre: "Programa riego 1",
      sectores: [1, 3, 5],
      horaInicio: "29/03/2021 - 11:37",
      dias: [true, false, true, false, true, false, false],
    },
    {
      id: 58786969,
      nombre: "Programa riego findes semana",
      sectores: [1, 2, 3],
      horaInicio: "15/02/2021 - 17:37",
      dias: [false, false, false, false, false, true, true],
    },
    {
      id: 48393838,
      nombre: "Programa riego 3",
      sectores: [5, 6, 7, 8],
      horaInicio: "20/02/2021 - 10:15",
      dias: [true, false, true, false, false, true, true],
    },
    {
      id: 26479578,
      nombre: "Programa riego semana",
      sectores: [1, 3, 4],
      horaInicio: "20/03/2021 - 12:35",
      dias: [true, true, true, true, true, false, false],
    },
    {
      id: 426473,
      nombre: "Programa riego 4",
      sectores: [1, 2],
      horaInicio: "15/02/2021 - 17:37",
      dias: [false, false, false, false, false, true, true],
    },
  ],
};
