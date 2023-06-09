<template>
  <div v-if="modalOpen" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 w-full h-screen flex items-center justify-center bg-black bg-opacity-50">
    <div class="relative w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
            Add Review
          </h3>
          <button @click.stop="emits('close-modal')" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <form @submit.prevent="submitReview">
          <!-- Modal body -->
          <div class="p-6 space-y-3">
              <label class="text-gray-300 font-bold py-2 block">Review</label>
              <textarea name="review" v-model="review.review" class="w-full text-gray-700 shadow border rounded border-gray-300 focus:outline-none focus:shadow-outline py-1 px-3 mb-3"/>
              <label class="text-gray-300 font-bold pt-2 block">Rating</label>
              <div class="flex items-center cursor-pointer">
                <svg v-for="rating in ratings" aria-hidden="true" class="w-5 h-5" @click.stop="review.rating = rating" :class="getRatingClass(rating)" @mouseover="possibleRating = rating" @mouseout="possibleRating = null" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>First star</title><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
              </div>
          </div>
          <!-- Modal footer -->
          <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
            <button @click.stop="emits('close-modal')" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit Review</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import {ref} from "vue";
import {useRoute} from "vue-router";

const props = defineProps({
  modalOpen: Boolean,
  movieId: Number
});

const emits = defineEmits(['close-modal', 'review-created']);
const possibleRating =ref(null)
const route = useRoute()

const review = ref({
  review: '',
  rating: 3,
  movie_id: route.params.id
})

const ratings = [1,2,3,4,5]

const getRatingClass = (star) => {
  if(possibleRating.value) {
    if(star <= possibleRating.value) {
      return 'text-yellow-400';
    } else {
      return 'text-gray-500 hover:text-yellow-500';
    }
  }

  if(star <= review.value.rating) {
    return 'text-yellow-400 hover:text-gray-500';
  } else {
    return 'text-gray-500 hover:text-yellow-500';
  }
}

const submitReview = async () => {
  const result = await axios.post('/api/reviews', review.value)

  emits('close-modal')
  emits('review-created')
}
</script>