export default {
  updateConfigureDevice(state, data) {
    state.configureDevice = data;
  },
  loadTypeDigitalInput(state, array) {
    // Vue.set(state, "digitalInput", array);
    // state.digitalInput = {...state.digitalInput };
    state.digitalInput = array;
  },
  loadTypeDigitalOutput(state, array) {
    // Vue.set(state, "digitalOutput", array);
    // state.digitalOutput = {...state.digitalOutput };
    state.digitalOutput = array;
  },
  loadTypeAnalogicalInput(state, array) {
    // Vue.set(state, "analogicalInput", array);
    // state.analogicalInput = {...state.analogicalInput };

    state.analogicalInput = array;
  },
  loadTypeAnalogicalOutput(state, array) {
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
    state.configureDeviceOutputInput = {
      digitalInput: value.digitalInput,
      digitalOutput: value.digitalOutput,
      analogicalOutput: value.analogicalOutput,
      analogicalInput: value.analogicalInput,
    };
  },
  loadDigitalOutput(state, value) {
    state.configureDeviceOutputInput.digitalOutput = value.listDigitalOutput;
  },
  loadDigitalInput(state, value) {
    state.configureDeviceOutputInput.digitalInput = value.listDigitalInput;
  },
  loadAnalogicalOutput(state, value) {
    state.configureDeviceOutputInput.analogicalOutput =
      value.listAnalogicalOutput;
  },
  loadAnalogicalInput(state, value) {
    state.configureDeviceOutputInput.analogicalInput =
      value.listAnalogicalInput;
  },
  loadAllDevice(state, value) {
    state.allDevice = value.listId;
  },
};
