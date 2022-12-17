<script setup>
import {Inertia} from '@inertiajs/inertia';
const props = defineProps({
    project: Object
});
let destroy = () => {
    if (confirm('Are you sure you want to delete this project?')) {
        Inertia.delete(route('projects.destroy', props.project.id));
    }
};
</script>

<template>
    <button @click="destroy()" class="my-2 button bg-red-400 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2">
        Delete
    </button>
</template>
