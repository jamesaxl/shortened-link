const routes = {
    login: 'login',
    logout: 'logout',
    register: 'register',
    links: 'links',
};

const apiUrl = process.env.MIX_API_URL;

const routing = {
    generate: (route, locale) => {
        return apiUrl + '/' + locale + '/' + routes[route];
    }
}

export default {
    install(Vue) {
        Vue.prototype.$routing = routing;
    },
};
