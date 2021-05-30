import gettersHead from "./Head/gettersHead";
import gettersDevice from "./Device/gettersDevice";
export default {
  ...gettersHead,
  ...gettersDevice,
  programDays: (state) => state.program.days,
  showLogin: (state) => state.showLogin,
  showRegistro: (state) => state.showRegistro,
  auth: (state) => state.auth,
};
