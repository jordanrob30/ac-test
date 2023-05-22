<template>
  <div class="container mx-auto">
    <form
        class="flex justify-between rounded-full bg-slate-800 px-4 py-2 focus-within:ring-2 focus-within:ring-cyan-600 hover:ring-2 hover:ring-cyan-600"
        @submit.prevent="sendSearch">
      <input class="w-full appearance-none bg-slate-800 focus:outline-none" type="text" v-model="searchTerm">
      <button
          class="ml-2 shrink-0 rounded-full bg-gradient-to-br from-sky-500 to-cyan-400 px-3 py-1 text-sm font-medium hover:from-sky-700 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-600/50"
          type="submit">Search
      </button>
    </form>
    <div class="text-2xl text-white text-center pt-8 px-8 pb-4" v-if="searchResults.length">
      Search term: {{ searchTerm }}
      <div class="text-lg text-white text-center p-3">
        Search results: {{ searchResults.length }}
      </div>
    </div>
    <div class="w-full flex flex-col gap-6 mt-8">
      <Movie v-for="movie in searchResults" :key="movie.id" :title="movie.title" :tagline="movie.tagline" :id="movie.id"
             :numOfReviews="movie.reviews.length" :average="movie.reviews_avg"/>
    </div>
    <div class="flex flex-col items-center" v-if="searchResults.length > 0">
      <PaginationBasic :meta="meta" :page="page" @update-page="updatePage($event)"/>
    </div>
  </div>
</template>

<script setup>

import {ref} from 'vue';
import Movie from "../components/Movie.vue";
import PaginationBasic from "../components/PaginationBasic.vue"

const searchTerm = ref('');
const searchResults = ref([]);
const meta = ref({})
const page = ref(1)

const updatePage = (newPage) => {
  page.value = newPage
  sendSearch()
}

const sendSearch = async () => {
  const {data} = await axios.post('/api/movies/search?page=' + page.value, {searchParam: searchTerm.value});
  searchResults.value = data.data
  meta.value = {...data.meta, ...data.links}
}
</script>