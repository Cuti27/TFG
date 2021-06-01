import axios from "axios";
import actionsHead from "./Head/actionsHead.js";
import actionsDevice from "./Device/actionsDevice.js";

// Función para añadir la cabecera de autenticación
const addAuthHeader = async(auth) => {
    return {
        headers: { Authorization: "Bearer " + auth },
    };
};

export default {
    ...actionsHead,
    ...actionsDevice,
    // Función para actualizar los dias
    updateDays({ commit, state }, index) {
        let obj = state.program.days;
        obj[index] = !obj[index];
        commit("updateDayProgram", obj);
    },

    updateLogin({ commit }, data) {
        commit("updateLogin", data);
    },
    updateRegistro({ commit }, data) {
        commit("updateRegistro", data);
    },
    async login({ commit }, data) {
        const request = "http://127.0.0.1:8000/api/login";
        let response = await axios.post(request, data).catch((err) => {
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

        console.log("Login");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadLogin", datosRecuperados);
        }
    },
    async logout({ commit, state }) {
        const request = "http://127.0.0.1:8000/api/logout";
        await axios
            .post(request, {}, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
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

    },
    async register({ commit }, data) {
        const request = "http://127.0.0.1:8000/api/register";
        let response = await axios.post(request, data).catch((err) => {
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

        console.log("Register");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadLogin", datosRecuperados);
        }
    },
};