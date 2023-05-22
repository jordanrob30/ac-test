import { createRouter, createWebHistory } from 'vue-router';

import Dashboard from '../pages/Dashboard.vue';
import Search from '../pages/Search.vue';
import Login from '../pages/Login.vue';
import Movie from "../pages/Movie.vue";

const routes = [
    {
        path: "/",
        name: "Dashboard",
        component: Dashboard
    },
    {
        path: "/login",
        name: "Login",
        component: Login,
    },
    {
        path: "/movie/:id",
        name: "Movie",
        component: Movie
    },
    {
        path: "/search",
        name: "Search",
        component: Search
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;