<script setup>

import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    invite: Object,
});

let reject = () => {
    if (confirm('Are you sure you want to reject this invite?')) {
        Inertia.delete(route('profile.invitations.reject', props.invite.id));
    }
};

let accept = () => {
    if (confirm('Are you sure you want to accept this invite?')) {
        Inertia.patch(route('profile.invitations.accept', props.invite.id));
    }
};

</script>

<template>
    <div class="flex justify-between">
        <div>
            <p class="mb-1">{{ invite.project.title }}</p>
            <p class="text-muted font-light text-sm">{{ invite.project.description }}</p>
        </div>
        <div class="flex">
            <button @click="accept()" class="my-2 button bg-green-600 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2">
                Accept
            </button>
            <button @click="reject()" class="my-2 button bg-red-400 text-white no-underline rounded-lg text-sm py-2 px-5 mr-2">
                Reject
            </button>
        </div>
    </div>
</template>
