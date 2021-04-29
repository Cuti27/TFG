import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        program: {
            days: [false, false, false, false, false, false, false],
        },
        cabezales: [{
                id: 1356434634,
                nombre: "Cabezal 1",
                fecha: "12/12/2020 12:12:12"
            },
            {
                id: 2346346346,
                nombre: "Cabezal 2",
                fecha: "12/12/2020 12:22:12"
            },
            {
                id: 3346346343,
                nombre: "Cabezal 3",
                fecha: "12/12/2020 12:32:12"
            },
            {
                id: 412321346,
                nombre: "Cabezal 4",
                fecha: "12/12/2020 12:42:12"
            },
            {
                id: 5,
                nombre: "Cabezal 5",
                fecha: "15/12/2020 12:12:12"
            }
        ],
        numCabezales: 5,
        numProgramas: 5,
        programas: [{
                id: 1234,
                nombre: 'Programador riego 1',
                sectores: [1, 3, 5],
                horaInicio: '29/03/2021 - 11:37',
                dias: [true, false, true, false, true, false, false]
            },
            {
                id: 58786969,
                nombre: 'Programador riego findes semana',
                sectores: [1, 2, 3],
                horaInicio: '15/02/2021 - 17:37',
                dias: [false, false, false, false, false, true, true]
            },
            {
                id: 48393838,
                nombre: 'Programador riego 3',
                sectores: [5, 6, 7, 8],
                horaInicio: '20/02/2021 - 10:15',
                dias: [true, false, true, false, false, true, true]
            },
            {
                id: 26479578,
                nombre: 'Programador riego semana',
                sectores: [1, 3, 4],
                horaInicio: '20/03/2021 - 12:35',
                dias: [true, true, true, true, true, false, false]
            },
            {
                id: 426473,
                nombre: 'Programador riego 4',
                sectores: [1, 2],
                horaInicio: '15/02/2021 - 17:37',
                dias: [false, false, false, false, false, true, true]
            },
        ],
    },
    mutations: {
        // Mutación para cambiar los días del state
        updateDayProgram(state, array) {
            Vue.set(state.program, "days", array);
            //! No se esto porque hay que ponerlo
            state.program = {...state.program };
        }
    },
    actions: {
        // Función para actualizar los dias 
        updateDays({ commit, state }, index) {
            // TODO: 
            let obj = state.program.days
            obj[index] = !obj[index];
            commit("updateDayProgram", obj);

        }
    },
    modules: {},
    getters: {
        programDays: state => {
            return state.program.days;
        }
    }
})