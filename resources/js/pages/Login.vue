<template>
    <div class="container mx-auto">
        <div class="border border-red-700 p-4 bg-red-500 text-white">
            {{ errorMessage }}
        </div>
        <form @submit.prevent="login">
            <label class="text-gray-300 font-bold py-2 block">Email Address</label>
            <input type="text" name="email" v-model="auth.email" class="w-full text-gray-700 shadow border rounded border-gray-300 focus:outline-none focus:shadow-outline py-1 px-3 mb-3"/>
            <label class="text-gray-300 font-bold py-2 block">Password</label>
            <input type="password" v-model="auth.password" name="password"  class="w-full text-gray-700 shadow border rounded border-gray-300 focus:outline-none focus:shadow-outline py-1 px-3 mb-3"/>
            <button type="submit" class="py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-700 mr-2">Login</button>
        </form>
    </div>
</template>

<script setup>

import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';


const auth = ref({email: "", password: ""});
const router = useRouter();
const errorMessage = ref('');
const processing = ref(false);


const login = async () => {
    processing.value = true;
    try {
        const {data} = await axios.post('/api/login', auth.value);
        router.push({name: 'Dashboard'});
    } catch(error) {
        const { response } = error;
        console.log(response, "RESPONSE");
        errorMessage.value = response.data.message;
    }
}


</script>