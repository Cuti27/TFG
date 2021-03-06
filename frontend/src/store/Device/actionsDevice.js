import axios from "axios";
import router from "@/router";
// Función para añadir la cabecera de autenticación
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

// Funcion para realizar la llamada mediante axios y realizar el tratamiento de errores
const doCall = async (request, auth = null) => {
  return await axios.get(request, auth).catch((err) => {
    if (err.response) {
      console.log("Error en la llamada a: " + request);
      console.log(err.response.data);
      console.log(err.response.status);
      console.log(err.response.headers);
      return null;
    }
  });
};
export default {
  async crearBasicDevice({ commit, state }, data) {
    commit("addIsLoading");
    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/head/" +
      state.selectedHead.id +
      "/device";
    console.log(state.auth);
    let response = await axios
      .post(request, data, await addAuthHeader(state.auth))
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
            "No se ha podido crear el dispositivo, intentalo más tarde"
          );
          return null;
        }
      });

    console.log("Dispositivo creado");
    console.log(response.data);

    // Actualizamos el estado
    if (response && response.data) {
      commit("updateConfigureDevice");
      commit(
        "updateComunicationSuccess",
        "Dispositivo registrado correctamente"
      );
      commit("removeIsLoading");
    }
  },
  // Funciones para obtener los tipos de salidas y entradas
  async getAnalogicalInput({ commit }) {
    commit("addIsLoading");
    // Realizamos la petición
    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/analogicalInput";
    let response = await doCall(request, null);

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      console.log("prueba");
      console.log(response.data);
      commit("loadTypeAnalogicalInput", datosRecuperados);
      commit("removeIsLoading");
    } else {
      commit("addGlobalError", "Error, intentalo más tarde");
    }
  },
  async getDigitalInput({ commit }) {
    commit("addIsLoading");
    // Realizamos la petición
    const request = "http://josemiguel.myqnapcloud.com:41063/api/digitalInput";
    let response = await doCall(request, null);

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadTypeDigitalInput", datosRecuperados);
      commit("removeIsLoading");
    } else {
      commit("addGlobalError", "Error, intentalo más tarde");
    }
  },
  async getAnalogicalOutput({ commit }) {
    commit("addIsLoading");
    // Realizamos la petición
    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/analogicalOutput";
    let response = await doCall(request, null);

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadTypeAnalogicalOutput", datosRecuperados);
      commit("removeIsLoading");
    } else {
      commit("addGlobalError", "Error, intentalo más tarde");
    }
  },
  async getDigitalOutput({ commit }) {
    commit("addIsLoading");
    // Realizamos la petición
    const request = "http://josemiguel.myqnapcloud.com:41063/api/digitalOutput";
    let response = await doCall(request, null);

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadTypeDigitalOutput", datosRecuperados);
      commit("removeIsLoading");
    } else {
      commit("addGlobalError", "Error, intentalo más tarde");
    }
  },
  async getTypeDevice({ commit }) {
    commit("addIsLoading");
    // Realizamos la petición
    const request = "http://josemiguel.myqnapcloud.com:41063/api/typeDevice";
    let response = await doCall(request, null);

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadTypeDevice", datosRecuperados);
      commit("removeIsLoading");
    } else {
      commit("addGlobalError", "Error, intentalo más tarde");
    }
  },
  async createDeviceId({ commit, dispatch, state }) {
    commit("addIsLoading");
    // Realizamos la petición
    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/create/deviceId";
    let response = await axios
      .get(request, await addAuthHeader(state.auth))
      .catch((err) => {
        if (err.response) {
          console.log("Error en la llamada a: " + request);
          console.log(err.response.data);
          console.log(err.response.status);
          console.log(err.response.headers);
          commit("removeIsLoading");
          commit("addGlobalError", "Error, demasiados id");
          return null;
        }
      });

    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      dispatch("getDeviceId", datosRecuperados);
      commit(
        "updateComunicationSuccess",
        "Identificador genenerado, y valido durante 24 horas"
      );
      commit("removeIsLoading");
    }
  },
  async getDeviceId({ commit, state }) {
    commit("addIsLoading");
    // Realizamos la petición
    const request = "http://josemiguel.myqnapcloud.com:41063/api/deviceId";

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
          commit("addGlobalError", "Error, intentalo más tarde");
          commit("removeIsLoading");
          return null;
        }
      });
    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadListDeviceId", datosRecuperados);
      commit("removeIsLoading");
    }
  },

  async deleteDeviceId({ commit, state, dispatch }, id) {
    commit("addIsLoading");
    // Realizamos la petición
    const request = "http://josemiguel.myqnapcloud.com:41063/api/deviceId";
    let toDelete = await addAuthHeader(state.auth);
    toDelete.data = { id };
    await axios.delete(request, toDelete).catch((err) => {
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
          "Error al borrar el dispositivo, intentalo más tarde"
        );
        commit("removeIsLoading");
        return null;
      }
    });

    dispatch("getDeviceId");
    commit(
      "updateComunicationSuccess",
      "Identificador eliminado correctamente"
    );
    commit("removeIsLoading");
  },
  async actionCreateDevice({ commit, state }, data) {
    commit("addIsLoading");
    // Realizamos la petición
    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/head/" +
      state.selectedHead.id +
      "/device";

    let response = await axios
      .post(request, data, await addAuthHeader(state.auth))
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
            "Error al crear el dispositivo, intentalo más tarde"
          );
          return null;
        }
      });
    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadConfigureDevice", datosRecuperados);
      commit(
        "updateComunicationSuccess",
        "Dispositivo registrado correctamente"
      );
      commit("removeIsLoading");
    }
  },

  async getAllDevice({ commit, state }) {
    commit("addIsLoading");
    // Realizamos la petición
    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/head/" +
      state.selectedHead.id +
      "/devices";

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
            "Error al obtener todos los dispositivos, intentalo más tarde"
          );
          return null;
        }
      });

    console.log(response.data);
    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadAllDevice", datosRecuperados);
      commit("removeIsLoading");
    }
  },
  async getAllInfoDevice({ commit, state }, id) {
    commit("addIsLoading");
    // Realizamos la petición
    const request = "http://josemiguel.myqnapcloud.com:41063/api/device/" + id;

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
          commit("addGlobalError", "Error, intentalo más tarde");
          commit("removeIsLoading");
          return null;
        }
      });

    console.log(response.data);
    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadConfigureDevice", datosRecuperados);
      commit("removeIsLoading");
    }
  },
  async resetConfigureDevice({ commit }) {
    commit("addIsLoading");
    commit("loadConfigureDevice", {});
    commit("removeIsLoading");
  },
  async createDigitalOutput({ commit, state }, data) {
    commit("addIsLoading");
    const idDevice = state.configureDevice.id;
    const head = state.selectedHead.id;

    let listDigitalOutput = [];
    data.forEach((element, index) => {
      let value = { ...element };
      value.deviceId = idDevice;

      if (!element.output) value.output = index + 1;
      else value.output = parseInt(element.output);
      listDigitalOutput.push(value);
    });
    console.log(listDigitalOutput);
    let dataSend = { idDevice, listDigitalOutput };

    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/head/" +
      head +
      "/digitalOutput";

    let response = await axios
      .post(request, dataSend, await addAuthHeader(state.auth))
      .catch((err) => {
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
            err.response.data.error
              ? err.response.data.error
              : "Debes seleccionar uno en el seleccionable e indicar un nombre"
          );
          commit("removeIsLoading");
          return null;
        }
      });

    console.log(response.data);
    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadDigitalOutput", datosRecuperados);
      commit(
        "updateComunicationSuccess",
        "Actualizadas las salidas digitales del dispositivo"
      );
      commit("removeIsLoading");
    }
  },
  async createDigitalInput({ commit, state }, data) {
    commit("addIsLoading");
    const idDevice = state.configureDevice.id;
    const head = state.selectedHead.id;

    let listDigitalInput = [];
    data.forEach((element, index) => {
      let value = { ...element };
      value.deviceId = idDevice;

      if (!element.input) value.input = index + 1;
      else value.input = parseInt(element.input);

      listDigitalInput.push(value);
    });

    let dataSend = { idDevice, listDigitalInput };

    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/head/" +
      head +
      "/digitalInput";

    let response = await axios
      .post(request, dataSend, await addAuthHeader(state.auth))
      .catch((err) => {
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
            "Debes seleccionar uno en el seleccionable e indicar un nombre"
          );
          commit("removeIsLoading");
          return null;
        }
      });

    console.log(response.data);
    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadDigitalInput", datosRecuperados);
      commit(
        "updateComunicationSuccess",
        "Actualizadas las entradas digitales del dispositivo"
      );
      commit("removeIsLoading");
    }
  },
  async createAnalogicalOutput({ commit, state }, data) {
    commit("addIsLoading");
    const idDevice = state.configureDevice.id;
    const head = state.selectedHead.id;

    let listAnalogicalOutput = [];
    data.forEach((element, index) => {
      let value = { ...element };
      value.deviceId = idDevice;

      if (!element.output) value.output = index + 1;
      else value.output = parseInt(element.output);

      listAnalogicalOutput.push(value);
    });

    let dataSend = { idDevice, listAnalogicalOutput };

    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/head/" +
      head +
      "/analogicalOutput";

    let response = await axios
      .post(request, dataSend, await addAuthHeader(state.auth))
      .catch((err) => {
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
            "Error al crear una salida analógica, intentalo más tarde"
          );
          commit("removeIsLoading");
          return null;
        }
      });

    console.log(response.data);
    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadAnalogicalOutput", datosRecuperados);
      commit(
        "updateComunicationSuccess",
        "Actualizadas las salidas analógicas del dispositivo"
      );
      commit("removeIsLoading");
    }
  },
  async createAnalogicalInput({ commit, state }, data) {
    commit("addIsLoading");
    const idDevice = state.configureDevice.id;
    const head = state.selectedHead.id;

    let listAnalogicalInput = [];
    data.forEach((element, index) => {
      let value = { ...element };
      value.deviceId = idDevice;

      if (!element.input) value.input = index + 1;
      else value.input = parseInt(element.input);

      listAnalogicalInput.push(value);
    });

    let dataSend = { idDevice, listAnalogicalInput };

    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/head/" +
      head +
      "/analogicalInput";

    let response = await axios
      .post(request, dataSend, await addAuthHeader(state.auth))
      .catch((err) => {
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
            "Error al crear la salida analógica, intentalo más tarde"
          );
          commit("removeIsLoading");
          return null;
        }
      });

    console.log(response.data);
    // Actualizamos el estado
    if (response && response.data) {
      let datosRecuperados = response.data;
      commit("loadAnalogicalInput", datosRecuperados);
      commit(
        "updateComunicationSuccess",
        "Actualizadas las entradas analógicas del dispositivo"
      );
      commit("removeIsLoading");
    }
  },
  async deleteDevice({ commit, state }, id) {
    commit("addIsLoading");
    // Realizamos la petición
    const request =
      "http://josemiguel.myqnapcloud.com:41063/api/device/" + id;
    let response = await axios
      .delete(request, await addAuthHeader(state.auth))
      .catch((err) => {
        if (err.response) {
          console.log("Error en la llamada a: " + request);
          console.log(err.response.data);
          console.log(err.response.status);
          if (err.response.status == 401) {
            commit("loadLogout");
          }

          if (
            err.response.status == 400 &&
            (err.response.data.sectors || err.response.data.emitters)
          ) {
            commit(
              "addGlobalError",
              "El dispositivo se encuentra en un programa, modifica o borra este para poder eliminarlo. "
            );
          } else {
            console.log(err.response.headers);
            commit("addGlobalError", "Error al borrar un dispositivo, no hemos podido contactart con el dispositivo");
          }

          commit("removeIsLoading");
          return null;
        }
      });

      if(!response.data.customError) router.push("Cabezales");
    commit("removeIsLoading");
   
  },
};
