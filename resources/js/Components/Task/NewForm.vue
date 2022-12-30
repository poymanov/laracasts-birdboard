<script setup>
import {useForm} from '@inertiajs/inertia-vue3';
const props = defineProps({
    project: Object,
});
let form = useForm({
    body: null,
    project_id: props.project.id
});
let submit = () => {
    form.post(route('tasks.store'));
    form.reset();
};
</script>

<template>
    <form @submit.prevent="submit">
        <input placeholder="Add a new task..." class="w-full" name="body" v-model="form.body">
        <div v-if="form.errors.body" v-text="form.errors.body" class="text-red-500 text-xs mb-2"></div>
    </form>
</template>
