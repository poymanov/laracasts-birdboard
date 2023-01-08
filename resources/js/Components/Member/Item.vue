<script setup>

import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    member: Object
});

let deleteMember = () => {
    if (confirm('Are you sure you want to delete this member?')) {
        Inertia.delete(route('projects.members.destroy', {projectId: props.member.project.id, projectMemberId: props.member.id}));
    }
};

</script>

<template>
    <div class="flex justify-between">
        <div>
            {{ member.user.name }}
        </div>
        <div>
            <button @click="deleteMember" class="my-2 button bg-red-400 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2">
                Delete
            </button>
        </div>
    </div>
</template>
