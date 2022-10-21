import axios from "axios";

const state = {
    user: {}
};

const getters = {};
const actions = {
    getUser({ commit }) {
        axios.get("/user/users-details").then(response => {
            commit("setUser", response.data.user);
        });
    },
    loginForm({}, userData) {
        // localStorage.setItem("fxins_token", userData.access_token);
        // // Current URL: https://my-website.com/page_a
        // const nextURL = "https://my-website.com/page_b";
        // const nextTitle = "My new page title";
        // const nextState = {
        //     additionalInformation:
        //         "Updated the URL with JS"
        // };
        // // This will create a new entry in the browser's history, without reloading
        // window.history.pushState(
        //     nextState,
        //     nextTitle,
        //     nextURL
        // );
        // // This will replace the current entry in the browser's history, without reloading
        // window.history.replaceState(
        //     nextState,
        //     nextTitle,
        //     nextURL
        // );
        // window.location.replace("/");
        // axios
        //     .post("/login", {
        //         user: user.email,
        //         password: user.password
        //     })
        //     .then(response => {
        //         if (response.data.access_token) {
        //             // Save token
        //             localStorage.setItem(
        //                 "fxins_token",
        //                 response.data.access_token
        //             );
        //             window.location.replace("/");
        //         }
        //     });
    }
};
const mutations = {
    setUser(state, data) {
        state.user = data;
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
