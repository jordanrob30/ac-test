<template>
    <div class="container mx-auto">
        <div class="mx-auto max-w-screen-lg px-3 py-6">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col items-center gap-x-8 rounded-md bg-slate-800 p-3 md:flex-row md:flex-wrap">
                    <div class="w-full flex flex-col flex-wrap items-center gap-y-2 md:flex-row  md:justify-between">
                        <p class="text-xl font-semibold">{{ movie.title }} / {{ movie.reviews_count }} Reviews</p>
                        <button @click.stop="reviewModalOpen = true" type="button" class="ml-auto mr-2 shrink-0 rounded-full bg-gradient-to-br from-sky-500 to-cyan-400 px-3 py-1 text-sm font-medium hover:from-sky-700 hover:to-cyan-600 focus:outline-none focus:ring-2 focus:ring-cyan-600/50">
                          Add Review
                        </button>
                        <p class="mt-3 text-gray-400 w-full">{{ movie.tagline }}</p>
                    </div>
                    <div class="w-full mt-4 mb-4">
                        {{ movie.overview }}
                    </div>
                    
                    <div class="hover:text-cyan-400 text-xl font-semibold border-b border-cyan-400 pb-2 mb-4">
                        Reviews
                    </div>
                    <div class="p-3 w-full mt-4 bg-slate-700 flex justify-between" v-for="review in movie.reviews">
                        <div class="text-gray-200">
                            {{ review.review }}
                        </div>
                      <div class="text-gray-200 flex items-center">
                        <svg v-for="index in review.rating" aria-hidden="true" class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <ReviewModal :modal-open="reviewModalOpen" id="review-modal" @close-modal="reviewModalOpen = false" :movie-id="movie.id" @review-created="getMovie(movie.id)"/>
</template>

<script setup>

import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import ReviewModal from "../components/ReviewModal.vue"

const route = useRoute();
const movie = ref({});
const reviewModalOpen = ref(false)

onMounted(() => {
    getMovie(route.params.id);
})

const getMovie = async (movieId) => {
    const { data } = await axios.get(`/api/movies/${movieId}`);
    movie.value = data.movie
}

</script>