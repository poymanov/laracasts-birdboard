<script setup>
const props = defineProps({
    invite: Object,
});
</script>

<template>
    <div>
        <div>
            <p class="mb-1">{{ invite.project.title }}</p>
            <p class="text-muted font-light text-sm">My Invitations</p>
        </div>

    </div>
</template>
