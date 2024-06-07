<script setup>
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const showModal = ref(false);

const props = defineProps({
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
  backgroundColor: {
    type: String,
    default: "#a1bdfd",
  },
  accentColor: {
    type: String,
    default: "#2b54b5",
  },
});

document.body.style.backgroundColor = props.backgroundColor;
</script>

<template>
  <Head title="Home" />

  <div v-if="todaysChallenge" class="page-container">
    <div class="flex flex-col justify-between">
      <div class="mx-16">
        <div class="mt-12">
          <h1 class="text-xl font-bold">
            TodaysDesignChallenge #{{ todaysChallenge.identifier }}
          </h1>
          <h2 class="prompt">
            {{ todaysChallenge.prompt }}
          </h2>
          <Link :href="route('submission.creator')" class="submit-button">
            Submit Entry • 7 hours left
          </Link>
        </div>

        <div class="mt-16">
          <h2 class="text-xl font-bold">
            Yesterday's Winner #{{ yesterdaysChallenge.identifier }}
          </h2>
        </div>
      </div>

      <div class="winner-image-container mx-16">
        <img
          class="winner-image"
          :src="'storage/' + yesterdaysChallenge.winner_submission.media"
          alt=""
          srcset=""
        />
      </div>

      <div class="mx-16 my-16">
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
  </div>
  <div v-else class="grid place-items-center h-screen no-challenge">
    no daily challenge found :(
  </div>
</template>

<style scoped>
.page-container {
  background: v-bind(backgroundColor);
  color: v-bind(accentColor);
}

.no-challenge {
  font-family: "Anton", sans-serif;
  text-transform: uppercase;
  color: v-bind(accentColor);
  font-size: 2em;
}

.prompt {
  font-family: "Anton", sans-serif;
  text-transform: uppercase;
  font-size: 8em;
  text-wrap: balance;
  line-height: 1;
  margin-bottom: 24px;
  margin-top: 8px;
}

.submit-button {
  background: v-bind(accentColor);
  padding: 16px 32px;
  border-radius: 48px;
  color: v-bind(backgroundColor);
  text-transform: uppercase;
  font-weight: 600;
}

.winner-image-container {
  max-width: 100%;
  position: relative;
}

.winner-image {
  min-width: 100%;
  border-radius: 24px;
}

h2 {
  margin-bottom: 16px;
}
</style>
