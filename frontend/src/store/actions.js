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
        commit('addIsLoading');
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
                commit('removeIsLoading');
                return null;
            }
        });

        console.log("Login");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadLogin", datosRecuperados);
            commit('removeIsLoading');
        }
    },
    async logout({ commit, state }) {
        commit('addIsLoading');
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
        commit('removeIsLoading');
    },
    async register({ commit }, data) {
        commit('addIsLoading');
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
                commit('removeIsLoading');
                return null;
            }
        });

        console.log("Register");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadLogin", datosRecuperados);
            commit('removeIsLoading');
        }
    },

    async createProgram({ commit, state }, data) {
        commit('addIsLoading');
        const request = "http://127.0.0.1:8000/api/program";

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
        await axios
            .post(request, data, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    if (err.response.data.customError) {
                        commit("addGlobalError", err.response.data.message);
                    } else {
                        console.log("Error en la llamda a: " + request);
                        console.log(err.response.data);
                        console.log(err.response.status);
                        if (err.response.status == 401) {
                            commit("loadLogout");
                        }
                        console.log(err.response.headers);
                    }

                    commit('removeIsLoading');
                    return null;
                }
            });

        // TODO: guardar programa
        commit("updateComunicationSuccess", "Programa creado correctamente");
        commit('removeIsLoading');
    },

    async listProgram({ commit, state }, page = 1) {
        commit('addIsLoading');
        const request =
            "http://127.0.0.1:8000/api/head/" +
            state.selectedHead.id +
            "/program?page=" +
            page;

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
                    commit('removeIsLoading');
                    return null;
                }
            });

        console.log("List programs");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadListProgram", datosRecuperados);
            commit('removeIsLoading');
        }
    },

    async loadProgramName({ commit }, data) {
        commit('addIsLoading');
        commit("updateProgramName", data);
        commit('removeIsLoading');
    },
    async closeError({ commit }) {
        commit("closeErrorMutation");
    },

    async deleteProgram({ commit, dispatch, state }, data) {
        commit('addIsLoading');
        let msg = {
            programId: data.id,
            headId: state.selectedHead.id,
        };

        const request = "http://127.0.0.1:8000/api/program/delete";
        let response = await axios
            .post(request, msg, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    if (err.response.data.customError) {
                        commit("addGlobalError", err.response.data.message);
                    } else {
                        console.log("Error en la llamda a: " + request);
                        console.log(err.response.data);
                        console.log(err.response.status);
                        if (err.response.status == 401) {
                            commit("loadLogout");
                        }
                        console.log(err.response.headers);
                    }

                    commit('removeIsLoading');
                    return null;
                }
            });

        console.log("Delete program");
        console.log(response.data);

        // Actualizamos el estado
        dispatch("listProgram");
        commit("updateComunicationSuccess", "Programa borrado correctamente");
        commit('removeIsLoading');
    },

    async loadUpdateName({ commit }, value) {
        commit('updateUpdatedName', value);
    }
};