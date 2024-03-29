<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/inertia-vue3';
import NotesFrom from '@/Components/Project/NotesForm.vue';
import ProjectCard from "@/Components/Project/Card.vue";
import ActivityCard from "@/Components/Activity/Card.vue";
import NewTaskForm from "@/Components/Task/NewForm.vue";
import TasksList from "@/Components/Task/List.vue";
import AvatarList from "@/Components/MemberAvatar/List.vue";

const props = defineProps({
    project: Object,
    tasks: Array,
    isOwner: Boolean,
    activities: Array,
    members: Array
});
</script>

<template>
    <BreezeAuthenticatedLayout>
        <Head :title="project.title"/>

        <header class="flex items-center mb-6 pb-4 px-3">
            <div class="flex justify-between items-center w-full">
                <p class="text-muted font-light mr-auto">
                    <Link :href="route('dashboard')" class="text-muted no-underline hover:underline">My Projects</Link>
                    / {{ project.title }}
                </p>

                <AvatarList :members="members" :project="project" />

                <div>
                    <Link v-if="isOwner" :href="route('projects.members.index', project.id)" class="button bg-blue-400 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2">Members</Link>
                    <Link v-if="isOwner" :href="route('projects.edit', project.id)" class="button bg-blue-400 text-white no-underline rounded-lg text-sm py-2 px-5">Edit Project</Link>
                </div>
            </div>
        </header>
        <main class="mb-6 px-3">
            <div class="lg:flex -mx-3">
                <div class="lg:w-3/4 px-3 mb-6">
                    <div class="mb-8">
                        <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>

                        <TasksList :tasks="tasks"/>

                        <div class="card bg-white p-5 rounded-lg shadow flex flex-col mb-3">
                            <NewTaskForm :project="project"/>
                        </div>
                    </div>

                    <div>
                        <h2 class="text-lg text-muted font-light mb-3">General Notes</h2>
                        <NotesFrom :project="project"/>
                    </div>
                </div>
                <div class="lg:w-1/4 px-3 lg:py-8">
                    <ProjectCard :project="project"/>
                    <ActivityCard :activities="activities"/>
                </div>
            </div>
        </main>
    </BreezeAuthenticatedLayout>
</template>
