import Mutations from './mutations';
import Actions from './actions';
import auth from './modules/auth';

export default {
    state: {
    },
    mutations: Mutations,
    actions: Actions,
    modules: {
        auth,
    },
};
