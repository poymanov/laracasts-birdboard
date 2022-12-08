<script setup>
import {Link, useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    project: [null, Object],
    submitUrl: String,
    cancelUrl: String,
    submitButtonTitle: String
});

let form = useForm({
    title: props.project ? props.project.title : null,
    description: props.project ? props.project.description : null,
});

let submit = () => {
    if (props.project) {
        form.patch(props.submitUrl);
    } else {
        form.post(props.submitUrl);
    }
};

</script>

<template>
    <form @submit.prevent="submit">
        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="title">Title</label>

            <div class="control">
                <input
                    type="text"
                    class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                    v-model="form.title"
                    name="title"
                    placeholder="My next awesome project"
                    required>
                <div v-if="form.errors.title" v-text="form.errors.title" class="text-red-500 text-xs mt-1"></div>
            </div>
        </div>

        <div class="field mb-6">
            <label class="label text-sm mb-2 block" for="description">Description</label>

            <div class="control">
            <textarea
                v-model="form.description"
                name="description"
                rows="10"
                class="textarea bg-transparent border border-grey-light rounded p-2 text-xs w-full"
                placeholder="I should start learning piano."
                required></textarea>
                <div v-if="form.errors.description" v-text="form.errors.description" class="text-red-500 text-xs mt-1"></div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <button type="submit" class="button bg-blue-400 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2">{{ this.submitButtonTitle }}</button>

                <Link :href="this.cancelUrl">Cancel</Link>
            </div>
        </div>
    </form>
</template>
