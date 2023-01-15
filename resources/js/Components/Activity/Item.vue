<script setup>
import Title from "@/Components/Activity/Title.vue";

const props = defineProps({
    activity: Object
});
</script>

<template>
    <li class="mb-2">
        <Title :activity="activity"/>
        <span class="text-muted">{{ activity.createdAtDiffForHumans }}</span>
    </li>
</template>
