import axios from "axios";

// Función para añadir la cabecera de autenticación
const addAuthHeader = async(auth) => {
    return {
        headers: { Authorization: "Bearer " + auth },
    };
};
export default {
    async getCabezales({ commit, state }, page = 1) {
        const request = "http://127.0.0.1:8000/api/head?page=" + page;
        console.log(state.auth);
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

        console.log("Lista de cabezales");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("updateListCabezales", datosRecuperados);
        }
    },

    async newCabezales({ commit, dispatch, state }, data) {
        const request = "http://127.0.0.1:8000/api/head";
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

        console.log("Cabezal creado");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            dispatch("getCabezales");
        }
    },

    async updateHead({ dispatch, state }, data) {
        const request = "http://127.0.0.1:8000/api/head/" + data.id;
        console.log(state.auth);
        await axios
            .post(request, data, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    console.log(err.response.headers);
                    return null;
                }
            });

        console.log("Cabezal actualizado");

        // Actualizamos el estado
        dispatch("getCabezales");
    },

    async deleteHead({ dispatch, state }, data) {
        const request = "http://127.0.0.1:8000/api/head/" + data.id + "/delete";
        console.log(state.auth);
        let response = await axios
            .delete(request, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    console.log(err.response.headers);
                    return null;
                }
            });

        console.log("Borrado cabezal");
        console.log(response.data);

        // Actualizamos el estado
        dispatch("getCabezales");
    },

    setSelectedHead({ commit }, data) {
        commit("setSelectedHead", data);
    },

    async getEmitterHead({ commit, state }) {
        const request = "http://127.0.0.1:8000/api/head/" + state.selectedHead.id + "/emitter";
        let response = await axios.get(request, await addAuthHeader(state.auth)).catch((err) => {
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

        console.log("Emitter");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadEmmiter", datosRecuperados);
        }
    },
    async getSectorHead({ commit, state }) {
        const request = "http://127.0.0.1:8000/api/head/" + state.selectedHead.id + "/sector";
        let response = await axios.get(request, await addAuthHeader(state.auth)).catch((err) => {
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

        console.log("Emitter");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadSectors", datosRecuperados);
        }
    },
};