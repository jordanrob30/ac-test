<template>
    <div class="container mx-auto">
        <div class="mx-auto max-w-screen-lg px-3 py-6">
            <div class="mb-6 text-2xl font-bold">
                Recent 
                <span class="bg-gradient-to-br from-sky-500 to-cyan-400 bg-clip-text text-transparent">Movies</span>
            </div>
            <Movie v-for="movie in recentMovies" :key="movie.id" :title="movie.title" :tagline="movie.tagline" :id="movie.id" :numOfReviews="movie.review_count"/>
        </div>

        <div class="mx-auto max-w-screen-lg px-3 py-6">
            <div class="mb-6 text-2xl font-bold">
                Recent 
                <span class="bg-gradient-to-br from-sky-500 to-cyan-400 bg-clip-text text-transparent">Reviews</span>
            </div>
            <div class="flex flex-col gap-6">
                <div class="flex flex-col items-center gap-x-8 rounded-md bg-slate-800 p-3 md:flex-row md:flex-wrap" v-for="review in recentReviews" :key="review.id">
                    <div class="w-full flex flex-col items-center gap-y-2 md:flex-row  md:justify-between">
                        <router-link class="hover:text-cyan-400" :to="{name: 'Movie', params: {id: review.movie_id}}">
                            <div class="text-xl font-semibold">Film Review 1</div>
                        </router-link>
                        <div class="ml-auto">
                            <a href="" class="text-xl font-semibold">0 Stars</a>
                        </div>
                    </div>
                    <p class="mt-3 text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse bibendum. Nunc non posuere consectetur, justo erat semper enim, non hendrerit dui odio id enim.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Movie from '../components/Movie.vue';

const recentMovies = ref([]);
const recentReviews = ref([]);

onMounted(async () => {

    const moviesResponse = await axios.get('/api/movies/recent');
    recentMovies.value = moviesResponse.data.movies;

    const reviewsResponse = await axios.get('/api/reviews/recent');
    recentReviews.value = reviewsResponse.data.reviews;
});

</script>