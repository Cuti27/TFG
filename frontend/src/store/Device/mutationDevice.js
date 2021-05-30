export default {
    updateConfigureDevice(state, data) {
        state.configureDevice = data;
    },
    loadDigitalInput(state, array) {
        // Vue.set(state, "digitalInput", array);
        // state.digitalInput = {...state.digitalInput };
        state.digitalInput = array;
    },
    loadDigitalOutput(state, array) {
        // Vue.set(state, "digitalOutput", array);
        // state.digitalOutput = {...state.digitalOutput };
        state.digitalOutput = array;
    },
    loadAnalogicalInput(state, array) {
        // Vue.set(state, "analogicalInput", array);
        // state.analogicalInput = {...state.analogicalInput };

        state.analogicalInput = array;
    },
    loadAnalogicalOutput(state, array) {
        // Vue.set(state, "analogicalOutput", array);
        // state.analogicalOutput = {...state.analogicalOutput };

        state.analogicalOutput = array;
    },
    loadTypeDevice(state, array) {
        state.typeDevice = array;
    },
    loadListDeviceId(state, array) {
        state.listDeviceId = array;
    },
    loadConfigureDevice(state, value) {
        state.configureDevice = value.device;
    },
    loadAllDevice(state, value) {
        state.allDevice = value.listId;
    }
};