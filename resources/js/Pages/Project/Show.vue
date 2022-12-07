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
            </div>
        </header>
    </BreezeAuthenticatedLayout>
</template>
