const state = {
    appData: {},
    modal_login: false
};

const actions = {};

const getters = {};

const mutations = {
    setAppData(state, dataApp) {
        state.appData = dataApp;
    },
    setModalLogin(state, value) {
        state.modal_login = value;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
