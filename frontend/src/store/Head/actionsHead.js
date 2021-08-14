import axios from "axios";
import router from '@/router';

// Función para añadir la cabecera de autenticación
const addAuthHeader = async(auth) => {
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
    async getCabezales({ commit, state }, page = 1) {
        commit("addIsLoading");
        const request = "http://josemiguel.myqnapcloud.com:41063/api/head?page=" + page;
        console.log(state.auth);
        let response = await axios
            .get(request, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    console.log(err.response.headers);
                    commit("removeIsLoading");
                    commit("addGlobalError", "Error al cargar los cabezales, intentalo más tarde");
                    return null;
                }
            });

        console.log("Lista de cabezales");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("updateListCabezales", datosRecuperados);
            commit("removeIsLoading");
        }
    },

    async newCabezales({ commit, dispatch, state }, data) {
        commit("addIsLoading");
        const request = "http://josemiguel.myqnapcloud.com:41063/api/head";
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
                        router.push("Home");
                    }
                    console.log(err.response.headers);
                    commit("addGlobalError", "No se ha podido crear el cabezal, intentalo más tarde");
                    commit("removeIsLoading");
                    return null;
                }
            });

        console.log("Cabezal creado");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            dispatch("getCabezales");
            commit("updateComunicationSuccess", "Creado el cabezal correctamente");
            commit("removeIsLoading");
        }
    },

    async updateHead({ commit, dispatch, state }, data) {
        commit("addIsLoading");
        const request = "http://josemiguel.myqnapcloud.com:41063/api/head/" + data.id;
        console.log(state.auth);
        await axios
            .post(request, data, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    console.log(err.response.headers);
                    commit("addGlobalError", "No se ha podido actualizar el cabezal, intentalo más tarde");
                    commit("removeIsLoading");
                    return null;
                }
            });

        console.log("Cabezal actualizado");

        // Actualizamos el estado
        dispatch("getCabezales");
        commit("updateComunicationSuccess", "Actualizado el cabezal correctamente");
        commit("removeIsLoading");
    },

    async deleteHead({ commit, dispatch, state }, data) {
        commit("addIsLoading");
        const request = "http://josemiguel.myqnapcloud.com:41063/api/head/" + data.id;
        console.log(state.auth);
        let response = await axios
            .delete(request, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    console.log(err.response.headers);
                    commit("addGlobalError", "No se ha podido borrar el cabezal, intentalo más tarde");
                    commit("removeIsLoading");
                    return null;
                }
            });

        console.log("Borrado cabezal");
        console.log(response.data);

        // Actualizamos el estado
        dispatch("getCabezales");
        commit("updateComunicationSuccess", "Cabezal borrado correctamente");
        commit("removeIsLoading");
    },

    async setSelectedHead({ commit }, data) {
        commit("setSelectedHead", data);
    },

    async getEmitterHead({ commit, state }) {
        commit("addIsLoading");
        const request =
            "http://josemiguel.myqnapcloud.com:41063/api/head/" + state.selectedHead.id + "/emitter";
        let response = await axios
            .get(request, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    if (err.response.status == 401) {
                        commit("loadLogout");
                        router.push("Home");
                    }
                    console.log(err.response.headers);
                    commit("addGlobalError", "Error, intentalo más tarde");
                    commit("removeIsLoading");
                    return null;
                }
            });

        console.log("Emitter");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadEmmiter", datosRecuperados);
            commit("removeIsLoading");
        }
    },
    async getSectorHead({ commit, state }) {
        commit("addIsLoading");
        const request =
            "http://josemiguel.myqnapcloud.com:41063/api/head/" + state.selectedHead.id + "/sector";
        let response = await axios
            .get(request, await addAuthHeader(state.auth))
            .catch((err) => {
                if (err.response) {
                    console.log("Error en la llamda a: " + request);
                    console.log(err.response.data);
                    console.log(err.response.status);
                    if (err.response.status == 401) {
                        commit("loadLogout");
                        router.push("Home");
                    }
                    console.log(err.response.headers);
                    commit("addGlobalError", "Error, intentalo más tarde");
                    commit("removeIsLoading");
                    return null;
                }
            });

        console.log("Emitter");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadSectors", datosRecuperados);
            commit("removeIsLoading");
        }
    },
};