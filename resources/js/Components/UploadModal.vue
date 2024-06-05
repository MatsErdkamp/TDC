<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

// Import filepond
import vueFilePond, { setOptions } from "vue-filepond";

// Import filepond plugins
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js";
import FilePondPluginImagePreview from "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js";

// Import filepond styles
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

const props = defineProps({
    csrf_token: String,
});

const filepondMediaInput = ref(null); // Reference the input to clear the files later
const filepondGalleryInput = ref(null); // Reference the input to clear the files later

const form = useForm({
    media: null,
    csrf_token: props.csrf_token,
});

// const submit = () => {
//     form.transform((data) => {
//         return {
//             ...data,
//             gallery: data.gallery.map((item) => item.serverId), // Pluck only the serverIds
//         };
//     }).put(route("update-profile"), {
//         onSuccess: () => {
//             filepondMediaInput.value.removeFiles();
//             filepondGalleryInput.value.removeFiles();
//         },
//     });
// };

// Create FilePond component
const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

// Set global options on filepond init
const handleFilePondInit = () => {
    setOptions({
        credits: false,
        server: {
            url: "/submission",
            headers: {
                "X-CSRF-TOKEN": props.csrf_token,
            },
        },
    });
};
// Set the server id from response
const handleFilePondMediaProcess = (error, file) => {
    form.media = file.serverId;
};
// Remove the server id on file remove
const handleFilePondMediaRemoveFile = (error, file) => {
    form.media = null;
};
</script>

<template>
    <!-- <form @submit.prevent="submit">
        <input type="text" v-model="form.name" />
        <input type="file" @input="form.media = $event.target.files[0]" />
        <progress
            v-if="form.progress"
            :value="form.progress.percentage"
            max="100"
        >
            {{ form.progress.percentage }}%
        </progress>
        <button type="submit">Submit</button>
    </form> -->

    <FilePond
        name="media"
        ref="filepondMediaInput"
        class-name="my-pond"
        allow-multiple="false"
        accepted-file-types="image/*"
        @init="handleFilePondInit"
        @processfile="handleFilePondMediaProcess"
        @removefile="handleFilePondMediaRemoveFile"
    />
</template>

<style scoped>
.upload-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(8px);
    background: linear-gradient(transparent, white);
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-modal {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    background: white;
    gap: 24px;
    padding: 16px;
    border: 1px solid rgb(200, 200, 200);
    border-radius: 16px;
    min-width: min(500px, 80%);
    max-width: 500px;
    min-height: 200px;
    max-height: 80%;
    box-shadow: 0px 8px 12px -8px rgba(0, 0, 0, 0.2);
}
</style>
