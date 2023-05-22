<template>
    <div class="movie w-full rounded-md bg-slate-800 p-3 mb-4">
        <div class="w-full">
            <router-link class="hover:text-cyan-400 float-left" :to="{name: 'Movie', params: {id: props.id}}">
                <p class="text-xl font-semibold">{{ props.title }}</p>
                <p class="mt-3 text-gray-400">{{ props.tagline }}</p>
            </router-link>
            <div class="float-right">
                <span href="" class="text-xl font-semibold">{{ props.numOfReviews }} Reviews</span>
            </div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    id: Number,
    title: String,
    tagline: String,
    numOfReviews: Number
});

</script>

<style>

</style>