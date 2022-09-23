const SET_CART = "SET_CART";
const SET_ITEM = "SET_ITEM";

const state = {
    cart: [],
    item: {},
};

const mutations = {
    [SET_CART](state, data) {
        state.cart = data;
    },
    [SET_ITEM](state, data) {
        state.item = {
            ...state.item,
            ...data,
        };
    },
};

const actions = {
    setCart({ commit }, data) {
        commit(SET_CART, data);
    },
    setItem({ commit }, data) {
        commit(SET_ITEM, data);
    },
};

const getters = {
    getCart: (state) => {
        return state.cart;
    },
    getItem: (state) => {
        return state.item;
    },
};

export default {
    state,
    mutations,
    actions,
    getters,
};
