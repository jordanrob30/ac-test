<template>
  <div class="container mx-auto">
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload file</label>
    <input class="py-2 px-4 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" @change="handleUpload($event)" id="file_input" type="file">
    <button type="button" @click.stop="submitFile" class=" w-full py-4 mt-4 ml-auto mr-2 shrink-0 rounded-full bg-gradient-to-br from-sky-500 to-cyan-400 px-3 py-1 text-sm font-medium hover:from-sky-700 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-600/50">
      {{(isUploading) ? 'Uploading...' : 'Submit'}}
    </button>
  </div>
  <div class="w-full flex flex-col gap-6 mt-8" v-if="movies.length > 0">
    <Movie v-for="movie in movies" :key="movie.id" :title="movie.title" :tagline="movie.tagline" :id="movie.id" :numOfReviews="movie.reviews.length" :average="movie.reviews_avg"/>
  </div>
  <div class="flex flex-col items-center mt-2" v-if="movies.length > 0">
    <PaginationBasic :meta="meta" :page="page" @update-page="updatePage($event)"/>
  </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import Movie from "../../components/Movie.vue"
import PaginationBasic from "../../components/PaginationBasic.vue"

const movies = ref([])
const file = ref(null)
const page = ref(1)
const isUploading = ref(false)
const meta = ref({})

const handleUpload = (e) => {
  file.value = e.target.files[0]
}

const updatePage = (newPage) => {
  page.value = newPage
  fetchMovies()
}

const fetchMovies = async () => {
  const movieResponse = await axios.get('/api/movies?page=' + page.value);
  movies.value = movieResponse.data.data
  meta.value = {...movieResponse.data.meta, ...movieResponse.data.links}
}

const submitFile = async () => {
  if(!isUploading.value) {
    isUploading.value = true
    const formData = new FormData();
    formData.append('file', file.value);

    await axios.post('/api/movies/upload', formData);
    isUploading.value = false

    await fetchMovies();
  }
}

onMounted(async () => {
  await fetchMovies();
})

</script>