export default {
  updateListCabezales(state, data) {
    state.cabezales = data.headList.data;
    state.cabezales.forEach((element) => {
      element.updated_at = element.updated_at
        .replace(".000000Z", "")
        .replace("T", " ");
    });
    state.numCabezales = data.total;
    state.current_page = data.headList.current_page;
    state.last_page = data.headList.last_page;
  },
  setSelectedHead(state, data) {
    state.selectedHead = data;
  },
  loadEmmiter(state, data) {
    state.emitter = data.emitterList;
  },
  loadSectors(state, data) {
    state.sectors = data.sectorList;
  },
  loadProgramProfile(state, data) {
    console.log("mutation");
    console.log(data);
    data.listPrograms.forEach((element, index) => {
      element.timer = data.timer[index];
      element.programDay = [
        element.mon,
        element.tue,
        element.wed,
        element.thu,
        element.fri,
        element.sat,
        element.sun,
      ];
      delete element.mon;
      delete element.tue;
      delete element.wed;
      delete element.thu;
      delete element.fri;
      delete element.sat;
      delete element.sun;
      element.sector = data.sector[index];
      element.emitter = data.emitter[index];
    });
    state.programProfile = data.listPrograms;
  },
};
