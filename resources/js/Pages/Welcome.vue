<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const showModal = ref(false);

defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  todaysChallenge: {
    type: Object,
  },
  yesterdaysChallenge: {
    type: Object,
  },
});

const navigateToSubmission = () => {
  router.visit("/submission/create");
};
</script>

<template>
  <div v-if="todaysChallenge" class="bg-white text-black">
    <div class="flex flex-row justify-between">
      <div class="mx-16 flex flex-col justify-between">
        <div class="mt-16">
          <h1 class="text-xl font-bold">
            TodaysDesignChallenge #{{ todaysChallenge.identifier }}
          </h1>
          <h2 class="text-6xl font-bold text-balance">
            {{ todaysChallenge.prompt }}
          </h2>
          <Link
            :href="route('submission.creator')"
            class="mt-4 px-4 py-2 bg-black text-white rounded-xl"
          >
            Submit Entry • 7 hours left
          </Link>
        </div>

        <div class="mb-16">
          <h2 class="text-xl font-bold">
            Yesterday's Winner #{{ yesterdaysChallenge.identifier }}
          </h2>
          <h3 class="text-6xl font-bold capitalize">
            {{ yesterdaysChallenge.winner_submission.user.name }}
          </h3>
          <small>{{ yesterdaysChallenge.winner_submission.user.email }}</small>
          <p class="text-xl font-bold">
            {{ yesterdaysChallenge.prompt }}
          </p>
          <div class="flex justify-center mt-4 space-x-4"></div>
        </div>
      </div>

      <div class="winner-image-container">
        <img
          class="winner-image"
          :src="'storage/' + yesterdaysChallenge.winner_submission.media"
          alt=""
          srcset=""
        />
      </div>
    </div>
  </div>
  <div class="grid place-items-center h-screen">
    no daily challenge found :(
  </div>

</template>

<style scoped>
.winner-image-container {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  flex: 1;
  height: 100vh;
  width: 70vw;
  padding: 8px;
}

.winner-image {
  max-height: 100%;
  border-radius: 8px;
}

h2 {
  margin-bottom: 16px;
}
</style>
