<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import InviteForm from "@/Components/Member/InviteForm.vue";
import List from "@/Components/Member/List.vue";
const props = defineProps({
    project: Object,
    members: Array
});
</script>

<template>
    <BreezeAuthenticatedLayout>
        <Head :title="'Member - ' + project.title"/>

        <header class="flex items-center mb-2 pb-2 px-3">
            <div class="flex justify-between items-end w-full">
                <p class="text-muted font-light">
                    <Link :href="route('dashboard')" class="text-muted no-underline hover:underline">My Projects</Link> /
                    <Link :href="route('projects.show', project.id)" class="text-muted no-underline hover:underline">{{ project.title }}</Link> /
                    Members
                </p>
            </div>
        </header>
        <main class="px-3">
            <div class="lg:flex -mx-3">
                <div class="lg:w-3/4 px-3 mb-6">
                    <List :members="members"/>
                </div>
                <div class="lg:w-1/4 px-3">
                    <div class="card bg-white p-5 rounded-lg shadow flex flex-col" style="height: 200px">
                        <h3 class="font-normal text-xl py-4 -ml-5 mb-3 border-l-4 border-blue-300 pl-4">Invite</h3>

                        <div class="mb-4 flex-1"><InviteForm :project="project"/></div>
                    </div>
                </div>
            </div>
        </main>
    </BreezeAuthenticatedLayout>
</template>
