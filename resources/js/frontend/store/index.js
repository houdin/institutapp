import { createStore } from "vuex";

import AppData from "./modules/appData";
import CurrentUser from "./modules/currentUser";
import Cart from "./modules/cart";
import Loading from "./modules/Loading";

const store = createStore({
    modules: {
        AppData,
        CurrentUser,
        Cart,
        Loading,
    },
});

export default store;
