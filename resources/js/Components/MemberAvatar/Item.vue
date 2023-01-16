<script setup>
const props = defineProps({
    url: String,
    memberName: String
});
</script>

<template>
    <img
        :src="url"
        :alt="memberName + '\'s avatar'"
        :title="memberName + '\'s avatar'"
        class="rounded-full w-8 mr-2"
    >
</template>
