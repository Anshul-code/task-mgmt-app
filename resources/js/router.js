import { createWebHistory, createRouter } from "vue-router";
import store from "./store";

import Home from './views/Home.vue';
import Register from './views/Register.vue';
import Login from './views/Login.vue';
import Dashboard from './views/Dashboard.vue';
import CreateTask from './views/tasks/CreateTask.vue';
import EditTask from './views/tasks/EditTask.vue';


const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/tasks/create',
        name: 'CreateTask',
        component: CreateTask,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/tasks/edit/:id',
        name: 'EditTask',
        component: EditTask,
        meta: {
            requiresAuth: true
        }
    },,
];


const router = createRouter({
    history: createWebHistory(),
    routes,
});


router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !store.getters.getBToken) { // if route requires authentication and user is not logged in
        // if not logged redirect to login page
        return { name: 'Login' };
    }

    if (to.meta.requiresAuth === false && store.getters.getBToken) { // if route doesn't requires authentication and user is logged in
        return { name: 'Dashboard' };
    }
});

export default router;