<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
  isAuthenticated: {
    type: Boolean,
    required: true,
  },
});

const form = useForm({
  media: null,
  description: "",
});

const handleImageUpload = (event) => {
  form.media = event.target.files[0];
};

const submitForm = () => {
  console.log(form);

  form.post("/submission/create", {
    onSuccess: () => {
      console.log("Submission successful");
    },
    onError: (errors) => {
      console.error("Submission failed", errors);
    },
  });
};
</script>

<template>
  <div class="container mx-auto p-4">
    <Head title="Submission Form" />

    <div v-if="!props.isAuthenticated" class="text-center">
      <h1 class="text-2xl font-bold mb-4">You need to login or register</h1>
      <div class="space-x-4">
        <Link href="/login" class="px-4 py-2 bg-blue-500 text-white rounded-lg"
          >Login</Link
        >
        <Link
          href="/register"
          class="px-4 py-2 bg-green-500 text-white rounded-lg"
          >Register</Link
        >
      </div>
    </div>

    <div v-else>
      <h1 class="text-2xl font-bold mb-4">Submit Your Entry</h1>
      <form @submit.prevent="submitForm" class="space-y-4">
        <div>
          <label for="media" class="block text-lg font-medium text-gray-700"
            >Upload Image</label
          >
          <input
            type="file"
            id="media"
            @change="handleImageUpload"
            class="mt-1 block w-full"
            required
          />
        </div>
        <div>
          <label
            for="description"
            class="block text-lg font-medium text-gray-700"
            >Description (200 words)</label
          >
          <textarea
            id="description"
            v-model="form.description"
            rows="5"
            class="mt-1 block w-full"
            maxlength="200"
            required
          ></textarea>
        </div>
        <button
          type="submit"
          class="px-4 py-2 bg-blue-500 text-white rounded-lg"
        >
          Submit
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.container {
  max-width: 600px;
}
</style>
