<script setup>
const props = defineProps({
    member: Object
});
</script>

<template>
    <div>
        {{ member.user.name }}
    </div>
</template>
