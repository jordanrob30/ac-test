import {defineStore} from "pinia";

export const useTokenStore = defineStore({
    id: 'token',
    state: () => ({
        token: null,
    }),
    getters: {
        getToken() {
            return this.token;
        },
    },
    actions: {
        setToken(token) {
            this.token = token;
        },
    },
    persist: {
        enabled: true
    }
});