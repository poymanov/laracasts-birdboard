<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
const props = defineProps({
    project: Object,
});
let form = useForm({
    body: null
});
let submit = () => {
    form.post(route('projects.tasks.store', props.project.uuid));
    form.reset();
};
</script>

<template>
    <form @submit.prevent="submit">
        <input placeholder="Add a new task..." class="w-full" name="body" v-model="form.body">
    </form>
</template>
