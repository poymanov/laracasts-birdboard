<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
</script>

<template>
    <BreezeAuthenticatedLayout>
        <header class="flex items-center mb-3 pb-4">
            <div class="flex justify-between items-end w-full">
                <h2 class="text-muted text-base font-light">My Projects</h2>
            </div>
        </header>

        <main class="lg:flex lg:flex-wrap">
            <div>No projects yet.</div>
        </main>
    </BreezeAuthenticatedLayout>
</template>
