<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import Card from '@/Components/Project/Card.vue';
import { computed } from 'vue';

const props = defineProps({
    projects: Array
});
const hasProjects = computed(() => props.projects.length > 0)
</script>

<template>
    <BreezeAuthenticatedLayout>
        <Head title="Dashboard"/>
        <header class="flex items-center mb-3 pb-4 px-3">
            <div class="flex justify-between items-end w-full">
                <h2 class="text-muted text-base font-light">My Projects</h2>
                <Link :href="route('projects.create')" class="button bg-blue-400 text-white no-underline rounded-lg text-sm py-2 px-5">
                    New Project
                </Link>
            </div>
        </header>

        <main class="lg:flex lg:flex-wrap">
            <div v-if="hasProjects" v-for="project in projects" class="lg:w-1/3 px-3 pb-6">
                <Card :project="project" :key="project.id" />
            </div>
            <div v-else class="px-3">No projects yet.</div>
        </main>
    </BreezeAuthenticatedLayout>
</template>
