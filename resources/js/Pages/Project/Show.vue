<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
const props = defineProps({
    project: Object,
});
</script>

<template>
    <BreezeAuthenticatedLayout>
        <Head :title="project.title"/>

        <header class="flex items-center mb-6 pb-4 px-3">
            <div class="flex justify-between items-end w-full">
                <p class="text-muted font-light">
                    <Link :href="route('dashboard')" class="text-muted no-underline hover:underline">My Projects</Link>
                    / {{ project.title }}
                </p>
                <Link :href="route('projects.edit', project.id)" class="button bg-blue-400 text-white no-underline rounded-lg text-sm py-2 px-5">Edit Project</Link>
            </div>
        </header>
    </BreezeAuthenticatedLayout>
</template>
