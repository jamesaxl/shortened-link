export default {
    namespaced: true,
    state: {
        data: null,
    },
    getters: {
        getData(state) {
            return state.data;
        },
    },
    mutations: {
        setData(state, data) {
            state.data = data;
        },
        initStore(state) {
            if (localStorage.getItem('data')) {
                state.data = JSON.parse(localStorage.getItem('data'));
            }
        },
    },
    actions: {
        data(context, data) {
            context.commit('data', data);
        },
        initStore(context) {
            context.commit('initStore');
        },
    },
};
