<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import Form from '@/Components/Project/Form.vue';
import DeleteButton from '@/Components/Project/DeleteButton.vue';

const props = defineProps({
    project: Object,
});

</script>

<template>
    <BreezeAuthenticatedLayout>
        <Head title="Edit Project"/>

        <div class="lg:w-1/2 lg:mx-auto bg-white p-6 md:py-12 md:px-16 rounded shadow">
            <h1 class="text-2xl font-normal mb-10 text-center">
                Edit Your Project
            </h1>
            <Form
                :project="project"
                :submit-button-title="'Save'"
                :cancel-url="route('projects.show', project.id)"
                :submit-url="route('projects.update', project.id)"
            />
            <DeleteButton :project="project" />
        </div>
    </BreezeAuthenticatedLayout>
</template>
