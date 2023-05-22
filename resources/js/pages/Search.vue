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
      <!-- Help text -->
      <span class="text-sm text-gray-700 dark:text-gray-400">
      Showing <span class="font-semibold text-gray-900 dark:text-white">{{meta.from}}</span> to <span class="font-semibold text-gray-900 dark:text-white">{{meta.to}}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{meta.total}}</span> Entries
      </span>
      <div class="inline-flex mt-2 xs:mt-0">
        <button
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            @click.stop="(meta.prev) ? updatePage(page - 1) : ''"
            :class="(!meta.prev) ? 'cursor-not-allowed' : ''">
          <svg aria-hidden="true" class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
          </svg>
          Prev
        </button>
        <button
            @click.stop="(meta.next) ? updatePage(page + 1) : ''"
            :class="(!meta.next) ? 'cursor-not-allowed' : ''" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border-0 border-l border-gray-700 rounded-r hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
          Next
          <svg aria-hidden="true" class="w-5 h-5 ml-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>

import {ref} from 'vue';
import Movie from "../components/Movie.vue";

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