import axios from "axios";

const state = {
    products: [],
    information: []
};
const getters = {};
const actions = {
    getCart({ commit }) {
        axios
            .get(window.Laravel.urls.shopping_cart)
            .then(response => {
                commit("setCart", response.data.cart);
            })
            .catch(error => console.error(error));
    }
};
const mutations = {
    setCart(state, cart) {
        state.products = cart.products;
        state.information = cart.information;
    },
    addProductsToCart(state, product) {
        const duplicatedProductIndex = state.products.findIndex(
            item => item.id === product.id
        );

        if (duplicatedProductIndex !== -1) {
            state.products[duplicatedProductIndex].quantity++;
            return;
        }

        product.quantity = 1;
        state.products.push(product);
    },
    removeProductToCart(state, id) {
        for (const [key, value] of Object.entries(state.products)) {
            if (value.id === id) {
                state.products.splice(key, 1);
            }
        }
    }
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
