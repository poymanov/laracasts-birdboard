<script setup>
import {useForm} from '@inertiajs/inertia-vue3';

const props = defineProps({
    project: Object,
});

let form = useForm({
    notes: props.project.notes
});

let submit = () => {
    form.patch(route('projects.update-notes', props.project.id));
};

</script>

<template>
    <form @submit.prevent="submit">
        <textarea
            name="notes"
            v-model="form.notes"
            class="card bg-white p-5 rounded-lg shadow flex border-0 flex-col text-default w-full mb-2"
            style="min-height: 200px"
            placeholder="Anything special that you want to make a note of?">{{ project.notes }}
        </textarea>

        <div v-if="form.errors.notes" v-text="form.errors.notes" class="text-red-500 text-xs mb-2"></div>

        <button type="submit" class="button bg-blue-400 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2">Save</button>
    </form>
</template>
