<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import Form from '@/Components/Project/Form.vue';
</script>

<template>
    <BreezeAuthenticatedLayout>
        <Head title="New Project" />

        <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
            <h1 class="text-2xl font-normal mb-10 text-center">
                Let's start something new
            </h1>

            <Form
                :submit-button-title="'Create'"
                :cancel-url="route('dashboard')"
                :submit-url="route('projects.store')"
            />
        </div>
    </BreezeAuthenticatedLayout>
</template>
