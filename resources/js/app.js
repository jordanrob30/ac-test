import './bootstrap';
import {createApp} from 'vue'
import router from './router';
import App from './App.vue'
import {useTokenStore} from "./store/auth";
import axios from "axios";
import {createPinia} from "pinia";
import piniaPersist from 'pinia-plugin-persist'

const tokenInterceptor = (config) => {
    const tokenStore = useTokenStore();
    const token = tokenStore.getToken;

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
};


axios.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        const tokenStore = useTokenStore();
        tokenStore.setToken(null);
        router.push({name: 'Login'})
        return Promise.reject(error);
    }
    return Promise.reject(error);
});

axios.interceptors.request.use(tokenInterceptor);

const pinia = createPinia()
pinia.use(piniaPersist)

createApp(App)
    .use(router)
    .use(pinia)
    .mount("#app")