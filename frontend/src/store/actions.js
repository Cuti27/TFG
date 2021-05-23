import axios from "axios";

// Funcion para realizar la llamada mediante axios y realizar el tratamiento de errores
const doCall = async(request, auth = null) => {
    return await axios.get(request, auth).catch(err => {
        if (err.response) {
            console.log("Error en la llamda a: " + request);
            console.log(err.response.data);
            console.log(err.response.status);
            console.log(err.response.headers);
            return null;
        }
    });
};

// Función para añadir la cabecera de autenticación
const addAuthHeader = async(auth) => {
    return {
        headers: { 'Authorization': 'Bearer ' + auth }
    }
};

export default {
    // Función para actualizar los dias
    updateDays({ commit, state }, index) {
        // TODO:
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

    // Funciones para obtener los tipos de salidas y entradas
    async getAnalogicalInput({ commit }) {
        // Realizamos la petición
        const request = 'http://127.0.0.1:8000/api/analogicalInput'
        let response = await doCall(request, null)

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            console.log('prueba');
            console.log(response.data);
            commit("loadAnalogicalInput", datosRecuperados)
        }
    },
    async getDigitalInput({ commit }) {
        // Realizamos la petición
        const request = 'http://127.0.0.1:8000/api/digitalInput'
        let response = await doCall(request, null)

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadDigitalInput", datosRecuperados)
        }
    },
    async getAnalogicalOutput({ commit }) {
        // Realizamos la petición
        const request = 'http://127.0.0.1:8000/api/analogicalOutput'
        let response = await doCall(request, null)

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadAnalogicalOutput", datosRecuperados)
        }
    },
    async getDigitalOutput({ commit }) {
        // Realizamos la petición
        const request = 'http://127.0.0.1:8000/api/digitalOutput';
        let response = await doCall(request, null);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadDigitalOutput", datosRecuperados)
        }
    },
    async login({ commit }, data) {
        const request = 'http://127.0.0.1:8000/api/login'
        let response = await axios.post(request, data).catch(err => {
            if (err.response) {
                console.log("Error en la llamda a: " + request);
                console.log(err.response.data);
                console.log(err.response.status);
                console.log(err.response.headers);
                return null;
            }
        });


        console.log("Login");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadLogin", datosRecuperados)
        }
    },
    async logout({ commit, state }) {
        const request = 'http://127.0.0.1:8000/api/logout'
        let response = await axios.post(request, {}, await addAuthHeader(state.auth)).catch(err => {
            if (err.response) {
                console.log("Error en la llamda a: " + request);
                console.log(err.response.data);
                console.log(err.response.status);
                console.log(err.response.headers);
                return null;
            }
        });

        console.log("Logout");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadLogout", datosRecuperados)
        }
    },
    async register({ commit }, data) {
        const request = 'http://127.0.0.1:8000/api/register'
        let response = await axios.post(request, data).catch(err => {
            if (err.response) {
                console.log("Error en la llamda a: " + request);
                console.log(err.response.data);
                console.log(err.response.status);
                console.log(err.response.headers);
                return null;
            }
        });


        console.log("Register");
        console.log(response.data);

        // Actualizamos el estado
        if (response && response.data) {
            let datosRecuperados = response.data;
            commit("loadLogin", datosRecuperados)
        }
    },
};