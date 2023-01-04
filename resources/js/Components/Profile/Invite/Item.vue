<script setup>

import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    invite: Object,
});

let destroy = () => {
    if (confirm('Are you sure you want to reject this invite?')) {
        Inertia.delete(route('profile.invitations.reject', props.invite.id));
    }
};

</script>

<template>
    <div class="flex justify-between">
        <div>
            <p class="mb-1">{{ invite.project.title }}</p>
            <p class="text-muted font-light text-sm">{{ invite.project.description }}</p>
        </div>
        <div>
            <button @click="destroy()" class="my-2 button bg-red-400 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2">
                Delete
            </button>
        </div>
    </div>
</template>
