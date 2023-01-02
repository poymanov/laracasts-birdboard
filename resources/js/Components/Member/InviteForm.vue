<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
const props = defineProps({
    project: Object,
});
let form = useForm({
    email: null
});
let submit = () => {
    form.post(route('projects.invitations.store', props.project.id));
};
</script>

<template>
    <form @submit.prevent="submit">
        <input
            placeholder="User e-mail"
            class="input bg-transparent border border-grey-light rounded p-2 text-xs w-full"
            name="email"
            v-model="form.email"
            type="email"
            required
        >

        <div v-if="form.errors.email" v-text="form.errors.email" class="text-red-500 text-xs mb-2"></div>

        <button type="submit" class="button bg-blue-400 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2 mt-2">Send</button>
    </form>
</template>
