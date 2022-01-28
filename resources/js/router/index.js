import VueRouter from 'vue-router';
import NotFound from '../Pages/NotFound';
import Redirect from '../Pages/Redirect';
import Login from '../Pages/Auth/Login';
import Register from '../Pages/Auth/Register';
import DashBoard from "../Pages/DashBoard";

const routes = [
    {
        path: '*',
        component: NotFound,
        name: '404'
    },
    {
        path: '/',
        redirect: {
            name: 'login',
            params: {
                locale: 'en',
            }
        },
    },
    {
        path: '/:locale/login',
        component: Login,
        name: 'login',
        meta: {
            guest: true
        },
    },
    {
        path: '/:locale/register',
        component: Register,
        name: 'register',
        meta: {
            guest: true
        },
    },
    {
        path: '/:locale/dashboard/:page?',
        component: DashBoard,
        name: 'dashboard',
        meta: {
            requiresAuth: true,
        },
    },
    {
        path: '/s/:token',
        component: Redirect,
        name: 'redirect'
    },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        if (!localStorage.getItem('data')) {
            next({
                name: 'login',
            });
        } else {
            next();
        }
    } else if (to.matched.some((record) => record.meta.guest)) {
        if (null !== localStorage.getItem('data')) {
            next({ name: 'dashboard' })
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
