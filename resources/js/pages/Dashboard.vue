<template>
    <div class="container mx-auto">
        <div class="mx-auto max-w-screen-lg px-3 py-6">
            <div class="mb-6 text-2xl font-bold">
                Recent 
                <span class="bg-gradient-to-br from-sky-500 to-cyan-400 bg-clip-text text-transparent">Movies</span>
            </div>
            <Movie v-for="movie in recentMovies" :key="movie.id" :title="movie.title" :tagline="movie.tagline" :id="movie.id" :numOfReviews="movie.reviews.length" :average="movie.reviews_avg"/>
        </div>

        <div class="mx-auto max-w-screen-lg px-3 py-6">
            <div class="mb-6 text-2xl font-bold">
                Recent 
                <span class="bg-gradient-to-br from-sky-500 to-cyan-400 bg-clip-text text-transparent">Reviews</span>
            </div>
            <div class="flex flex-col gap-6">
                <Review v-for="review in recentReviews" :review="review" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import Movie from '../components/Movie.vue';
import Review from "../components/Review.vue"

const recentMovies = ref([]);
const recentReviews = ref([]);

onMounted(async () => {

    const moviesResponse = await axios.get('/api/movies/recent');
    recentMovies.value = moviesResponse.data.movies;

    const reviewsResponse = await axios.get('/api/reviews/recent');
    recentReviews.value = reviewsResponse.data.data;
});

</script>