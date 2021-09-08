import axios from "axios";
import router from "@/router";
import actionsHead from "./Head/actionsHead.js";
import actionsDevice from "./Device/actionsDevice.js";

// Función para añadir la cabecera de autenticación
const addAuthHeader = async (auth) => {
  return {
    headers: {
      Authorization: "Bearer " + auth,
      withCredentials: true,
      "X-XSRF-TOKEN": getCookie("XSRF-TOKEN"),
    },
  };
};

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}

export default {
  ...actionsHead,
  ...actionsDevice,
  async fetchUser({ commit, state }) {
    let res = await axios.get(
      "http://josemiguel.myqnapcloud.com:41063/api/user",
      await addAuthHeader(state.auth)
    );
    if (res && res.data) commit("setUser", res.data);
  },
  async fetchUserHistory({ commit, state }) {
    let res = await axios.get(
      "http://josemiguel.myqnapcloud.com:41063/api/user/history",
      await addAuthHeader(state.auth)
    );
    if (res) commit("setUserHistory", res.data);
  },
  offSnacbar({ commit }) {
    commit("updateComunicationSuccess", "");
  },
  updateWindowWidth({ state }, value) {
    state.windowWidth = value;
  },
  updateWindowHeight({ state }, value) {
    state.windowHeight = value;
  },
  // Función para actualizar los dias
  updateDays({ commit, state }, index) {
    let obj = state.program.days;
    obj[index] = !obj[index];
    commit("updateDayProgram", obj);
  },
  updateAllDays({ commit }, days) {
    commit("updateDayProgram", days);
  },

  updateLogin({ commit }, data) {
    commit("updateLogin", data);
  },
  updateRegistro({ commit }, data) {
    commit("updateRegistro", data);
  },

  async login({ commit, state }, data) {
    commit("addIsLoading");
    await axios
      .get("http://josemiguel.myqnapcloud.com:41063/sanctum/csrf-cookie")
      .then((csrf) => {
        console.log(csrf);
      });
    console.log(await addAuthHeader(state.auth));
    const request = "http://josemiguel.myqnapcloud.com:41063/api/login";
    let response = await axios
      .post(request, data, await addAuthHeader(state.auth))
      .catch((err) => {
        if (err.response) {
          console.log("Error en la llamada a: " + request);
          if (err.response.status == 401) {
            commit("loadLogout");
          }
          commit("addGlobalError", "Credenciales erróneas");
          commit("removeIsLoading");
          return null;
        }
      });

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadLogin", datosRecuperados);
      commit("removeIsLoading");
    }
  },
  async logout({ commit, state }) {
    commit("addIsLoading");
    const request = "http://josemiguel.myqnapcloud.com:41063/api/logout";
    await axios
      .post(request, {}, await addAuthHeader(state.auth))
      .catch((err) => {
        if (err.response) {
          console.log("Error en la llamada a: " + request);
          console.log(err.response.data);
          console.log(err.response.status);
          if (err.response.status == 401) {
            commit("loadLogout");
          }
          console.log(err.response.headers);
        }
      });

    console.log("Logout");

    commit("loadLogout");
    commit("removeIsLoading");
  },
  async register({ commit }, data) {
    commit("addIsLoading");
    const request = "http://josemiguel.myqnapcloud.com:41063/api/register";
    let response = await axios.post(request, data).catch((err) => {
      if (err.response) {
        console.log("Error en la llamada a: " + request);
        console.log(err.response.data);
        console.log(err.response.status);
        if (err.response.status == 401) {
          commit("loadLogout");
        }
        console.log(err.response.headers);
        commit(
          "addGlobalError",
          "No te has podido registrar con esos datos, revisalos y vuelve a intentarlo"
        );
        commit("removeIsLoading");
        return null;
      }
    });

    console.log("Register");
    console.log(response.data);

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadLogin", datosRecuperados);
      commit("updateComunicationSuccess", "Registro realizado con exito");
      commit("removeIsLoading");
    }
  },

  async createProgram({ commit, state }, data) {
    commit("addIsLoading");
    const request = "http://josemiguel.myqnapcloud.com:41063/api/program";

    let list = [];
    data.emitter.forEach((element, index) => {
      if (element) list.push(state.emitter[index].output);
    });

    data.emitter = list;
    list = [];

    data.sector.forEach((element, index) => {
      if (element) list.push(state.sectors[index].output);
    });

    data.sector = list;

    data.name = state.programName;

    data.headId = state.selectedHead.id;
    let response = await axios
      .post(request, data, await addAuthHeader(state.auth))
      .catch((err) => {
        console.log("=============");
      console.log(err.response);
      console.log("=============");
        if (err.response) {
          if (err.response.data.customError) {
            commit("addGlobalError", err.response.data.message);
          } else {
            console.log("Error en la llamada a: " + request);
            console.log(err.response.data);
            console.log(err.response.status);
            if (err.response.status == 401) {
              commit("loadLogout");
            }
            console.log(err.response.headers);
          }

          commit("removeIsLoading");
          return null;
        }
      });

      if(!response.data.customError){
        router.push("Programas");
        commit("updateComunicationSuccess", "Programa creado correctamente");
      }
    commit("removeIsLoading");
  },

  async listProgram({ commit, state }, page = 1) {
    commit("addIsLoading");
    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/head/" +
      state.selectedHead.id +
      "/program?page=" +
      page;

    let response = await axios
      .get(request, await addAuthHeader(state.auth))
      .catch((err) => {
        if (err.response) {
          console.log("Error en la llamada a: " + request);
          console.log(err.response.data);
          console.log(err.response.status);
          if (err.response.status == 401) {
            commit("loadLogout");
          }
          console.log(err.response.headers);
          commit("removeIsLoading");
          commit(
            "addGlobalError",
            "No se ha podido cargar los programas, asegurate de escoger un cabezal"
          );
          return null;
        }
      });

    console.log("List programs");
    console.log(response.data);

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadListProgram", datosRecuperados);
      commit("removeIsLoading");
    }
  },

  async loadProgramName({ commit }, data) {
    commit("addIsLoading");
    commit("updateProgramName", data);
    commit("removeIsLoading");
  },
  async closeError({ commit }) {
    commit("closeErrorMutation");
  },

  async deleteProgram({ commit, dispatch, state }, data) {
    commit("addIsLoading");
    let msg = {
      data: {
        programId: data.id,
        headId: state.selectedHead.id,
      },
      headers: {
        Authorization: "Bearer " + state.auth,
        withCredentials: true,
        "X-XSRF-TOKEN": getCookie("XSRF-TOKEN"),
      },
    };

    const request = "http://josemiguel.myqnapcloud.com:41063/api/program";
    let response = await axios.delete(request, msg).catch((err) => {
      console.log("=============");
      console.log(err.response);
      console.log("=============");
      if (err.response) {
        if (err.response.data.customError) {
          commit("addGlobalError", err.response.data.message);
        } else {
          console.log("Error en la llamada a: " + request);
          console.log(err.response.data);
          console.log(err.response.status);
          if (err.response.status == 401) {
            commit("loadLogout");
          }
          console.log(err.response.headers);
        }

        commit("removeIsLoading");
        return null;
      }
    });

    console.log("Delete program");
    console.log(response.data);

    // Actualizamos el estado
    if(!response.data.customError){
      commit("updateComunicationSuccess", "Programa borrado correctamente");
    }
    dispatch("listProgram");
    commit("removeIsLoading");
  },

  async loadUpdateName({ commit }, value) {
    commit("updateUpdatedName", value);
  },

  async changeProgram({ commit, dispatch, state }, { id }) {
    commit("addIsLoading");

    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/program/" + id + "/activate";
    await axios.get(request, await addAuthHeader(state.auth)).catch((err) => {
      if (err.response) {
        if (err.response.data.customError) {
          commit("addGlobalError", err.response.data.message);
        } else {
          console.log("Error en la llamada a: " + request);
          console.log(err.response.data);
          console.log(err.response.status);
          if (err.response.status == 401) {
            commit("loadLogout");
          }
          console.log(err.response.headers);
          commit(
            "addGlobalError",
            "Error, no se ha podido conectar con el servidor"
          );
        }
        commit("removeIsLoading");
        return null;
      }
    });

    
    // Actualizamos el estado
    dispatch("listProgram");
    commit("removeIsLoading");
  },

  async setTempProgram({ commit }, program) {
    console.log(program);
    console.log("jajaxd");
    commit("setTempProgram", program);
  },
};
