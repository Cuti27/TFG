import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        program: {
            days: [false, false, false, false, false, false, false],
        }
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