import gettersHead from "./Head/gettersHead";
import gettersDevice from "./Device/gettersDevice";
export default {
    ...gettersHead,
    ...gettersDevice,
    programDays: (state) => state.program.days,
    showLogin: (state) => state.showLogin,
    showRegistro: (state) => state.showRegistro,
    auth: (state) => state.auth,
    programas: (state) => state.programas,
    programName: (state) => state.programName,
    comunicationError: (state) => state.comunicationError,
    comunicationSuccess: (state) => state.comunicationSuccess,
    isLoading: (state) => state.isLoading,
    numProgramas: (state) => state.numProgramas,
    updateName: (state) => state.updateName,
    windowHeight: (state) => state.windowHeight,
    windowWidth: (state) => state.windowWidth,
};