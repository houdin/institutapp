const state = {
    loading: false,
};
const getters = {};
const actions = {
    loading({ commit }) {
        commit("setLoading");
    },
};
const mutations = {
    setLoading(state) {
        state.loading = !state.loading;
    },
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations,
};
