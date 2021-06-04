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
        state.emitter = data.emitterList
    },
    loadSectors(state, data) {
        state.sectors = data.sectorList
    },
};