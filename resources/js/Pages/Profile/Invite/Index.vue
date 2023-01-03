<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/inertia-vue3';
import List from "@/Components/Profile/Invite/List.vue";
const props = defineProps({
    invitations: Array,
});
</script>

<template>
    <BreezeAuthenticatedLayout>
        <Head title="Invitations"/>

        <header class="flex items-center mb-2 pb-2 px-3">
            <div class="flex items-end w-full">
                <p class="text-muted font-light mr-auto">My Invitations</p>
            </div>
        </header>
        <main class="px-3">
            <div class="lg:flex -mx-3">
                <div class="w-full px-3 mb-6">
                    <List :invitations="invitations" />
                </div>
            </div>
        </main>
    </BreezeAuthenticatedLayout>
</template>
