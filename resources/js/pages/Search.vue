<template>
    <div class="container mx-auto">
        <form class="rounded-full bg-slate-800 px-4 py-2 focus-within:ring-2 focus-within:ring-cyan-600 hover:ring-2 hover:ring-cyan-600" @submit.prevent="sendSearch">
            <input class="w-full appearance-none bg-slate-800 focus:outline-none" type="text" v-model="searchTerm">
            <button class="ml-2 shrink-0 rounded-full bg-gradient-to-br from-sky-500 to-cyan-400 px-3 py-1 text-sm font-medium hover:from-sky-700 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-600/50" type="submit">Search</button>
        </form>
        <div class="text-2xl text-white text-center pt-8 px-8 pb-4" v-if="searchResults.length">
            Search term: {{ searchTerm }}
            <div class="text-lg text-white text-center p-3">
                Search results: {{ searchResults.length }}
            </div>
        </div>
        <div class="w-full flex flex-col gap-6 mt-8">
            <div class="flex flex-col items-center gap-x-8 rounded-md bg-slate-800 p-3 md:flex-row md:flex-wrap" v-for="result in searchResults" :key="result.id">
                <div class="w-full flex flex-col items-center gap-y-2 md:flex-row  md:justify-between">
                    <router-link class="hover:text-cyan-400" :to="{name: 'Movie', params: {id: result.id}}">
                        <div class="text-xl font-semibold">{{ result.title }}</div>
                        <p class="mt-3 text-gray-400">{{ result.tagline }}</p>
                    </router-link>
                    <div class="ml-auto">
                        <a href="" class="text-xl font-semibold"># Reviews</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script setup>

import { ref } from 'vue';

const searchTerm = ref('');
const searchResults = ref([]);

const sendSearch = async () => {

    const { data } = await axios.post('/api/movies/search', { searchParam: searchTerm.value });
    searchResults.value.push(...data);

}




</script>