<script setup>
import {useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    task: Object,
});
let form = useForm({
    project_id: props.task.projectId,
    body: props.task.body ?? null,
    completed: props.task.completed
});
let submit = () => {
    form.patch(route('tasks.update', props.task.id));
};
</script>
<template>
    <div>
        <form @submit.prevent="submit">
            <div class="flex items-center">
                <input name="body" v-model="form.body" class="text-default bg-card w-full" :class="task.completed ? 'line-through text-muted' : ''">
                <input name="completed" v-model="form.completed" type="checkbox" v-on:change="submit" :checked="!!task.completed">
            </div>
            <div v-if="form.errors.body" v-text="form.errors.body" class="text-red-500 text-xs mb-2"></div>
        </form>
    </div>
</template>
