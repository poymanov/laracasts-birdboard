<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
</script>

<template>
    <BreezeAuthenticatedLayout>
        <Head title="Dashboard"/>
        <header class="flex items-center mb-3 pb-4">
            <div class="flex justify-between items-end w-full">
                <h2 class="text-muted text-base font-light">My Projects</h2>
                <Link :href="route('projects.create')" class="button bg-blue-400 text-white no-underline rounded-lg text-sm py-2 px-5">
                    New Project
                </Link>
            </div>
        </header>

        <main class="lg:flex lg:flex-wrap">
            <div>No projects yet.</div>
        </main>
    </BreezeAuthenticatedLayout>
</template>
