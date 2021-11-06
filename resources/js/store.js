export default {
    state: {
        result: []
    },
    mutations: {
        setResultGame(state, result) {
            state.result = result;
        },
    },
    actions: {
        setResultGame(context, result) {
            context.commit('setResultGame', result);
        },
    },
}
