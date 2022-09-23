import { createStore } from "vuex";
import createPersistedState from "vuex-persistedstate";
import cart from "./cart";

const store = createStore({
    plugins: [
        createPersistedState({
            storage: window.sessionStorage,
        }),
    ],
    state: {},
    mutations: {},
    actions: {},
    modules: {
        cart,
    },
});

export default store;
