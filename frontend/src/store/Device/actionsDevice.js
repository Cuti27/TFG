import axios from "axios";
// Función para añadir la cabecera de autenticación
const addAuthHeader = async(auth) => {
    return {
        headers: { Authorization: "Bearer " + auth },
    };
};

// Funcion para realizar la llamada mediante axios y realizar el tratamiento de errores
const doCall = async(request, auth = null) => {
    return await axios.get(request, auth).catch((err) => {
        if (err.response) {
            console.log("Error en la llamda a: " + request);
            console.log(err.response.data);
            console.log(err.response.status);
            console.log(err.response.headers);
            return null;
        }
    });
};
export default {
    async crearBasicDevice({ commit, state }, data) {
        const request =
            "http://127.0.0.1:8000/api/head/" + state.selectedHead.id + "/device";
        console.log(state.auth);
        let response = await axios
            .post(request, data, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    if (err.response.status == 401) {
                        commit("loadLogout");
                    }
                    console.log(err.response.headers);
                    return null;
                }
            });

        console.log("Dispositivo creado");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            commit("updateConfigureDevice");
        }
    },
    // Funciones para obtener los tipos de salidas y entradas
    async getAnalogicalInput({ commit }) {
        // Realizamos la petición
        const request = "http://127.0.0.1:8000/api/analogicalInput";
        let response = await doCall(request, null);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            console.log("prueba");
            console.log(response.data);
            commit("loadAnalogicalInput", datosRecuperados);
        }
    },
    async getDigitalInput({ commit }) {
        // Realizamos la petición
        const request = "http://127.0.0.1:8000/api/digitalInput";
        let response = await doCall(request, null);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadDigitalInput", datosRecuperados);
        }
    },
    async getAnalogicalOutput({ commit }) {
        // Realizamos la petición
        const request = "http://127.0.0.1:8000/api/analogicalOutput";
        let response = await doCall(request, null);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadAnalogicalOutput", datosRecuperados);
        }
    },
    async getDigitalOutput({ commit }) {
        // Realizamos la petición
        const request = "http://127.0.0.1:8000/api/digitalOutput";
        let response = await doCall(request, null);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadDigitalOutput", datosRecuperados);
        }
    },
    async getTypeDevice({ commit }) {
        // Realizamos la petición
        const request = "http://127.0.0.1:8000/api/typeDevice";
        let response = await doCall(request, null);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadTypeDevice", datosRecuperados);
        }
    },
    async createDeviceId({ dispatch, state }) {
        // Realizamos la petición
        const request = "http://127.0.0.1:8000/api/create/deviceId";
        let response = await axios
            .get(request, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    console.log(err.response.headers);
                    return null;
                }
            });

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            dispatch("getDeviceId", datosRecuperados);
        }
    },
    async getDeviceId({ commit, state }) {
        // Realizamos la petición
        const request = "http://127.0.0.1:8000/api/deviceId";

        let response = await axios
            .get(request, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    if (err.response.status == 401) {
                        commit("loadLogout");
                    }
                    console.log(err.response.headers);
                    return null;
                }
            });
        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadListDeviceId", datosRecuperados);
        }
    },

    async actionCreateDevice({ commit, state }, data) {
        // Realizamos la petición
        const request =
            "http://127.0.0.1:8000/api/head/" + state.selectedHead.id + "/device";

        let response = await axios
            .post(request, data, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    if (err.response.status == 401) {
                        commit("loadLogout");
                    }
                    console.log(err.response.headers);
                    return null;
                }
            });
        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadConfigureDevice", datosRecuperados);
        }
    },

    async getAllDevice({ commit, state }) {
        // Realizamos la petición
        const request =
            "http://127.0.0.1:8000/api/device/" + state.selectedHead.id;

        let response = await axios
            .get(request, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    if (err.response.status == 401) {
                        commit("loadLogout");
                    }
                    console.log(err.response.headers);
                    return null;
                }
            });

        console.log(response.data)
            // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadAllDevice", datosRecuperados);
        }
    },
    async getAllInfoDevice({ commit, state }, data) {
        // Realizamos la petición
        const request =
            "http://127.0.0.1:8000/api/device/";

        let response = await axios
            .post(request, data, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    if (err.response.status == 401) {
                        commit("loadLogout");
                    }
                    console.log(err.response.headers);
                    return null;
                }
            });

        console.log(response.data)
            // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadConfigureDevice", datosRecuperados);
        }
    },
};